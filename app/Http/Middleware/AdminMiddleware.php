<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!\Illuminate\Support\Facades\Auth::check() || !\Illuminate\Support\Facades\Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}