<?php

namespace App\Http\Middleware;

use App\Seller;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotSeller
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'seller')
	{
	    if (! Auth::guard($guard)->check() || Auth::guard($guard)->user()->status != 1) {
	        return redirect('/seller/login');
	    }

	    $seller = Seller::find(Auth::guard($guard)->user()->id);
	    $seller->last_seen = now();
	    $seller->save();
	    
	    return $next($request);
	}
}