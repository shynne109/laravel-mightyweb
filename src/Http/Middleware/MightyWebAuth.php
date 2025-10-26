<?php

namespace MightyWeb\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MightyWebAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Redirect to login page
            return redirect()->route('login')->with('error', 'Please login to access MightyWeb admin panel.');
        }

        // Optional: Check if user has admin role or specific permission
        // Uncomment and modify based on your application's authorization logic
        // if (!Auth::user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized access to MightyWeb admin panel.');
        // }

        return $next($request);
    }
}
