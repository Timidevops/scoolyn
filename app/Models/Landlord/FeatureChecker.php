<?php

namespace App\Models\Landlord;

use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\Student;

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
       return self::featureTotalStudents() == Student::query()->count();
   }
}
