<?php

namespace App\Http\Middleware\Landlord;

use App\Models\Tenant\ScoolynTenant;
use Closure;
use Illuminate\Http\Request;

class IsSubscriptionActiveMiddleware
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

        if ( ! ScoolynTenant::isSubscriptionActive() ){
            return redirect()->route('inactiveSubscription');
        }

        return $next($request);
    }
}
