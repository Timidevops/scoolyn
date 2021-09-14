<?php


namespace App\Actions\Tenant\Teacher\Designation;


use Illuminate\Database\Eloquent\Model;

class RemoveTeacherAsClassTeacherAction
{
    public function execute(Model $teacher)
    {
        foreach ($teacher->classArm as $classArm){
            $classArm->update([
                'class_teacher' => null,
            ]);
        }
    }
}
