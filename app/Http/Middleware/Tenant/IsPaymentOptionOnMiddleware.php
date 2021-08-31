<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Tenant\Setting;
use Closure;
use Illuminate\Http\Request;

class IsPaymentOptionOnMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( ! Setting::isPaymentStatusOn() ){
            abort(404);
        }

        return $next($request);
    }
}
