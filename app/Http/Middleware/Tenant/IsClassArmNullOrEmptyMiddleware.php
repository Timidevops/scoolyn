<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IsClassArmNullOrEmptyMiddleware
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
        if( Setting::isAcademicCalendarSet() ){
            if ( ClassArm::all()->isEmpty() || ClassArm::all() == null ){
                Session::flash('warningFlash', 'Add class arm by section.');
                return redirect()->route('listClass');
            }
        }

        return $next($request);
    }
}
