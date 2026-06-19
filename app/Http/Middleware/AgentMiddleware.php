<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgentMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        if (
            auth()->check()
            &&
            auth()->user()->role === 'agent'
        ) {

            return $next($request);

        }


        abort(403);

    }
}