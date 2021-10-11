<?php


namespace App\Actions\Tenant\Teacher\Designation;


use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;

class RemoveTeacherAsClassTeacherAction
{
    public function execute(Model $teacher)
    {
//        if(! $teacher->hasRole(User::CLASS_TEACHER_USER)){
//            return;
//        }

        foreach ($teacher->classArm as $classArm){
            $classArm->update([
                'class_teacher' => null,
            ]);
        }
    }
}
