<?php

namespace App\Http\Middleware;

use Closure;

class ClearanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() &&
            !$request->user()->hasPermissionTo('Administer roles & permissions')) {
            abort('401');
        }

        if ($request->user() &&
            !$request->user()->hasRole('content-creator')) {
            abort('401');
        }

        return $next($request);
    }
}
