<?php

namespace App\Http\Middleware\custom;

use Closure;
use Illuminate\Http\Request;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role === 'user')
            abort(403, 'HyperSee: You do not have valid role to access!');

        return $next($request);
    }
}
