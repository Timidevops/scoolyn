<?php

namespace App\Http\Controllers\Tenant\Setting;

use App\Http\Controllers\Controller;
use App\Models\Landlord\FeatureChecker;
use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionSettingsController extends Controller
{
    public function edit()
    {
        $planSubscription = ScoolynTenant::getCurrentSubscription();

        return view('Tenant.pages.setting.subscriptionSetting.edit', [
            'planName' => $planSubscription->getPlan->name,
            'planExpiry' => Carbon::parse($planSubscription->ends_at)->format('d F, Y h:i A'),
            'planStatus' => ScoolynTenant::getSubscriptionStatus(),
            'featureTotalStudents' => FeatureChecker::featureTotalStudents(),
            'totalStudents' => Student::query()->count(),
            'isStudentFeatureLimitReached' => FeatureChecker::isStudentFeatureLimitReached(),
        ]);
    }
}
