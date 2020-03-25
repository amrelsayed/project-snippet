<?php

namespace App\Http\Middleware;

use Closure;

class ApiKey
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
        if ($request->header('apiKey') && $request->header('apiKey') == 'y4rKeKQ9EY2$pc4Gx1tbhN@8idwhkZVx1W') {
            return $next($request);
        }

        return response()->Json('Not Authorized', 403);
    }
}
