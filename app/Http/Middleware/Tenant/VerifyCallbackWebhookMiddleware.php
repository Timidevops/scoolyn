<?php

namespace App\Http\Middleware\Tenant;

use Closure;
use Illuminate\Http\Request;

class VerifyCallbackWebhookMiddleware
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
        if(! $request->hasHeader('Ib-Checkout-Auth')){
            abort("404");
        }
        if($request->header('Ib-Checkout-Auth') != env('CHECKOUT_API_KEY')){
            abort("404");
        }

        return $next($request);
    }
}
