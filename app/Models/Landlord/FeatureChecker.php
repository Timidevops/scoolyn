<?php

namespace App\Models\Landlord;

use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\Student;
use function Webmozart\Assert\Tests\StaticAnalysis\float;

class FeatureChecker
{
    public static function currentSubscription()
    {
        return ScoolynTenant::getCurrentSubscription();
    }

    public static function featureTotalStudents()
    {

       return self::currentSubscription()->getPlan->getFeatureByEnName(Feature::TOTAL_NUMBER_OF_STUDENT)->value ?? 0;
    }

   public static function isStudentFeatureLimitReached(): bool
   {
       $studentAddonTotal =  self::featureTotalStudentAddons() ? self::featureTotalStudentAddons()->value : 0;

       $totalPackageStudents = $studentAddonTotal + self::featureTotalStudents();

       return $totalPackageStudents == Student::query()->count();
   }

   public static function featureTotalStudentAddons()
   {
       return PlanFeatureAddon::getPlanFeatureAddon();
   }

   public static function hasAdmissionAutomationFeature(): bool
   {
       return self::currentSubscription()->getPlan->getFeatureByEnName(Feature::ADMISSION_AUTOMATION)->value ?? 0;
   }
}
