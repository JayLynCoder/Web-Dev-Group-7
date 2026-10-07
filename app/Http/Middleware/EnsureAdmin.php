<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! session()->has('user_id')) {
            return redirect()->route('login');
        }

        abort_unless(session('is_admin'), 403);

        return $next($request);
    }
}