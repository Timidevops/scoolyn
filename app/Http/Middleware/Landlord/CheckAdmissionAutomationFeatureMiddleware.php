<?php

namespace App\Http\Middleware\Landlord;

use App\Models\Landlord\FeatureChecker;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAdmissionAutomationFeatureMiddleware
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
        if ( ! FeatureChecker::hasAdmissionAutomationFeature() ){
            abort(404);
        }
        return $next($request);
    }
}
