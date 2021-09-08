<?php

namespace App\Http\Middleware\Landlord;

use App\Models\Landlord\Feature;
use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\Student;
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
        $featureTotalStudents = ScoolynTenant::current()
            ->subscription(ScoolynTenant::getCurrentSubscription()->slug)
            ->getFeatureValue(Feature::TOTAL_NUMBER_OF_STUDENT_SLUG);

        $totalStudents = Student::query()->count();

        if ( $totalStudents != $featureTotalStudents ){
            Session::flash('warningFlash', 'Maximum student reached.');

            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
