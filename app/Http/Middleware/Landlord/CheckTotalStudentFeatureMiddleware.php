<?php

namespace App\Http\Middleware\Landlord;

use App\Models\Landlord\FeatureChecker;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckTotalStudentFeatureMiddleware
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
        if ( FeatureChecker::isStudentFeatureLimitReached() ){

            Session::flash('warningFlash', 'Maximum student reached.');

            return redirect()->route('subscriptionSetting');
        }

        return $next($request);
    }
}
