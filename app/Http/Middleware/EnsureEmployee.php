<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/** Logged-in, non-admin users only. Admins are sent to the admin dashboard. */
class EnsureEmployee
{
    public function handle(Request $request, Closure $next)
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login');
        }

        if (session('is_admin')) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
