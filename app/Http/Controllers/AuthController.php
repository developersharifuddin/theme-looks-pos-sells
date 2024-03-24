<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'store_id' => 'required',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'store_id' => $request->store_id,
            ]);

            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            if ($exception->errorInfo[1] === 1062) {
                // Duplicate entry error (error code 1062)
                return response()->json([
                    'message' => 'Email address is already in use',
                ], 409); // HTTP status code 409 (Conflict)
            }



            // Other database errors
            return response()->json([
                'message' => 'Failed to register user',
                'error' => $exception->getMessage(),
            ], 500); // HTTP status code 500 (Internal Server Error)
        }
    }



    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');
            $remember = $request->boolean('remember', false);

            if (!Auth::attempt($credentials, $remember)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken('api_token', ['*'], now()->addWeek())->plainTextToken;
            // return $user->createToken($request->device_name)->plainTextToken; 
            // $token = $user->createToken('api_token', ['create', 'read', 'update'], now()->addWeek())->accessToken; 

            return response()->json([
                'token' => $token,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => $e->validator->errors()->first(),
            ], 401);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function generateToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }


    public function logout(Request $request)
    {
        // $user->tokens()->where('id', $tokenId)->delete();

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
}
