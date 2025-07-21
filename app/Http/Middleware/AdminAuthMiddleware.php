<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $isAdmin = Session::get('is_admin') && Auth::check() && Auth::user()->email === 'admin@gmail.com';
        $isLoginRoute = $request->routeIs('auth-login-basic') || $request->routeIs('auth-login-basic.submit');

        if (!$isAdmin && !$isLoginRoute) {
            // Not admin and not on login page: redirect to login
            return redirect()->route('auth-login-basic');
        }

        if ($isAdmin && $isLoginRoute) {
            // Already admin, trying to access login: redirect to dashboard
            return redirect('/admin');
        }

        return $next($request);
    }
}