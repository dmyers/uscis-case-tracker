<?php

namespace App\Http\Middleware;

use Closure;

class SetJsonHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
