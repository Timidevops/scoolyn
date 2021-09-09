<?php

namespace App\Models\Landlord;

use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\Student;
use function Webmozart\Assert\Tests\StaticAnalysis\float;

class FeatureChecker
{
   public static function featureTotalStudents()
   {
       return ScoolynTenant::current()
           ->subscription(ScoolynTenant::getCurrentSubscription()->slug)
           ->getFeatureValue(Feature::TOTAL_NUMBER_OF_STUDENT_SLUG);
   }

   public static function isStudentFeatureLimitReached(): bool
   {

       $studentAddonTotal =  self::featureTotalStudentAddons() ? self::featureTotalStudentAddons()->value : 0;

       $totalPackageStudents = $studentAddonTotal + self::featureTotalStudents();

       return $totalPackageStudents != Student::query()->count();
   }

   public static function featureTotalStudentAddons()
   {
       return PlanFeatureAddon::getPlanFeatureAddon();
   }
}
