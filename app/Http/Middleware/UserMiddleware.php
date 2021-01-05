<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserMiddleware
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
        if(!$request->user()->hasAnyRole(['superadmin', 'operator', 'eksekutif'])) {
            Auth::logout();
            abort(403);
        }
        
        return $next($request);
    }
}
