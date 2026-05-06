<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->is_admin) {
            return redirect()->route('customer.login')->with('error', 'Please login to access this page.');
        }

        return $next($request);
    }
}