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

//        $classArm = ClassArm::query()
//            ->where('school_class_id', $input['schoolClassId'])
//            ->where('class_section_id', $input['classSectionId'])
//            ->where('class_section_category_id', $input['classSectionCategoryId'])->first();


        $classArm->students = $classArm->students == null ? [$input['studentId']]
            : [...$classArm->students,$input['studentId']];


        $classArm->save();

    }

}
