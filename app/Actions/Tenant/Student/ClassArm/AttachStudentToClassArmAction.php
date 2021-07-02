<?php


namespace App\Actions\Tenant\Student\ClassArm;


use App\Models\Tenant\ClassArm;

class AttachStudentToClassArmAction
{
    public function execute(array $input)
    {
        /**
         * this action adds a student to a class arm; which is dependant on the school class,
         * class section and class section category.
        **/

        $this->schoolClassId              = $input['schoolClassId'];

        $this->classSectionId             = $input['classSectionId'];

        $this->classSectionCategoryId     = $input['classSectionCategoryId'];


        $classArm = ClassArm::query()
            ->where('school_class_id', $this->schoolClassId)
            ->where('class_section_id', $this->classSectionId)
            ->where('class_section_category_id', $this->classSectionCategoryId)->first();


        $classArm->students = $classArm->students == null ? $input['studentId']
            : [...$classArm->students,$input['studentId']];


        $classArm->save();

    }

}
