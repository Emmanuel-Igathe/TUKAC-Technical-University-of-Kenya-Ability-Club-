<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckExecutive
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isExecutive()) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
