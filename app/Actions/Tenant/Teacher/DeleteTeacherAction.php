<?php


namespace App\Actions\Tenant\Teacher;


use App\Actions\Tenant\Teacher\Designation\RemoveTeacherAsClassTeacherAction;
use App\Actions\Tenant\Teacher\Designation\RemoveTeacherAsSubjectTeacher;
use Illuminate\Database\Eloquent\Model;

class DeleteTeacherAction
{
    public function execute(Model $teacher)
    {
        (new RemoveTeacherAsClassTeacherAction)->execute($teacher);

        (new RemoveTeacherAsSubjectTeacher)->execute($teacher);

        $teacher->delete();

        $teacher->user->delete();
    }
}
