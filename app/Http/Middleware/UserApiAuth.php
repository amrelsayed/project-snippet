<?php

namespace App\Http\Middleware;

use App\Models\User\Buyer;
use Closure;

class UserApiAuth
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
            $buyer = Buyer::where('token', $request->header('accessToken'))->first();
            
            if ($buyer) {
                $request->request->add(['user_id' => $buyer->id]);
                return $next($request);
            }
        }

        return response()->Json('Not Authorized', 403);
    }
}
