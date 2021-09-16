<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Tenant\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IsReportCardBreakdownFormatSetMiddleware
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
        if ( ! Setting::isReportCardBreakdownFormatCreated() ){
            Session::flash('warningFlash', 'Kindly set report card breakdown.');

            return redirect()->route('reportCardBreakdownFormatSetting');
        }

        return $next($request);
    }
}
