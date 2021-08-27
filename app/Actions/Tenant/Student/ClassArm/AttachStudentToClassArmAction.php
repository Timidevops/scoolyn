<?php


namespace App\Actions\Tenant\Student\ClassArm;


use App\Models\Tenant\ClassArm;
use Illuminate\Database\Eloquent\Model;

class AttachStudentToClassArmAction
{
    public function execute(Model $classArm, array $input)
    {
        /**
         * this action adds a student to a class arm; which is dependant on the school class,
         * class section and class section category.
        **/

        $classArm->students = $classArm->students == null ? [$input['studentId']]
            : [...$classArm->students,$input['studentId']];

        $classArm->save();

    }

}
