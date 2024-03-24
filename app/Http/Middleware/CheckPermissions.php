<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermissions
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        // Get the currently authenticated user
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has any of the required permissions
        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        // If the user does not have any of the required permissions, redirect or return a response as needed
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
