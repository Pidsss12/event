<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        if ($role === 'admin' && !$user->isAdmin()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        if ($role === 'user' && !$user->isUser()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
