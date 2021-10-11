<?php


namespace App\Actions\Tenant\Teacher\Designation;


use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;

class RemoveTeacherAsSubjectTeacher
{
    public function execute(Model $teacher)
    {
        if(! $teacher->hasRole(User::SUBJECT_TEACHER_USER)){
            return;
        }

        foreach ($teacher->subjectTeacher as $subject){
            $subject->update([
                'teacher_id' => null,
            ]);
        }
    }
}
