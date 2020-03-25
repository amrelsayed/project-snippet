<?php

namespace App\Http\Middleware;

use App\Seller;
use Closure;

class SellerApiAuth
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
        if ($request->header('accessToken')) {
            $seller = Seller::where('api_token', $request->header('accessToken'))->first();
            
            if ($seller) {
                $seller->last_seen = now();
                $seller->save();
                $request->request->add(['seller_id' => $seller->id]);
                return $next($request);
            }
        }

        return response()->Json('Not Authorized', 403);
    }
}
