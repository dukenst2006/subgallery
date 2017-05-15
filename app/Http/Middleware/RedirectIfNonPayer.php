<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNonPayer
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
        if ($request->user() && ! $request->user()->subscribed('main')) {
            if (Auth::check()) {
                // This user has signed up but membership has expired
            } else {
                // This user is not a paying customer...
                return redirect('billing');
            }
        }

        return $next($request);
    }
}
