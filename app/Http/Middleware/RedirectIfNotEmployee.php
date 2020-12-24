<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard="employee")
    {
        if(!auth()->guard($guard)->check()) {
            return redirect(route('teacher.login'));
        }
        return $next($request);
    }
}
