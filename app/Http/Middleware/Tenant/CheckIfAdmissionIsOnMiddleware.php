<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Tenant\Setting;
use Closure;
use Illuminate\Http\Request;

class CheckIfAdmissionIsOnMiddleware
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
        if( ! Setting::isAdmissionOn() ){
            abort(404);
        }

        return $next($request);
    }
}
