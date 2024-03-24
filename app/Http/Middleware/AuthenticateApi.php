<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateApi
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::guard('api')->check()) {
            // Check if the user is an admin
            if (Auth::guard('api')->user()->role === 'admin') {
                return $next($request);
            }
            // If not an admin, return unauthorized response
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        // If not authenticated, return unauthorized response
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
}
