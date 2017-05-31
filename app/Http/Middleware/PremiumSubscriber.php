<?php

namespace App\Http\Middleware;

use Closure;

class PremiumSubscriber
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
            $request->user()->hasRole('content-creator') ||
            $request->user()->hasRole('admin')) {
            return $next($request);
        } elseif ($request->user() && ! $request->user()->subscribed('primary', 'premium')) {
            // This user isn't a premium subscriber
            return redirect('settings/subscription/plan');
        }

        return $next($request);
    }
}
