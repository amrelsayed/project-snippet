<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // For super admin
        if (Auth::user()->id == 1 || Auth::user()->id == 5)
        {
            return $next($request);
        }else{
            return redirect('/admin');
        }
        return $next($request);
    }
}
