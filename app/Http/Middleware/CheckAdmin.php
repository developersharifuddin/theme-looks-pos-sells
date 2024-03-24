<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // return redirect('/login'); // Redirect to home or login page if not admin

        // if (auth()->check() && (!auth()->user()->role === 'admin')) {
        //     abort(403, 'Unauthorized action && You do not have permission to access this page.');
        // }
        return $next($request);
        // dd(auth()->user()->role);
    }
}
