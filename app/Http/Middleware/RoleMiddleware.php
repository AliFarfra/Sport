<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles) // Accept multiple roles
    {
        if (!Auth::check() || !Auth::user()->roles()->whereIn('role', $roles)->exists()) {
            return redirect('/')->with('error', 'You do not have access to this resource.');
        }
    
        return $next($request);
    }
}