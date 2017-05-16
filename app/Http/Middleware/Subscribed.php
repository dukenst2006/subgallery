<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Subscribed
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
            ! $request->user()->subscribed('subscriber') ||
            ! $request->user()->subscribed('premium'))
        {
            // This user has signed up but membership has expired
            return redirect('settings/subscription/card');
        }

        return $next($request);
    }
}
