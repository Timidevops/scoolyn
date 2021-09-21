<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Tenant\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IsAcademicCalendarSetMiddleware
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

        if( ! Setting::isAcademicCalendarSet() ){
            Session::flash('warningFlash', 'Kindly current academic session and term.');

            return redirect()->route('academicSession');
        }

        return $next($request);
    }
}
