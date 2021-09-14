<?php


namespace App\Actions\Tenant\Teacher\Designation;


use Illuminate\Database\Eloquent\Model;

class RemoveTeacherAsSubjectTeacher
{
    public function execute(Model $teacher)
    {
        foreach ($teacher->subjectTeacher as $subject){
            $subject->update([
                'teacher_id' => null,
            ]);
        }
    }
}
