<?php


namespace App\Actions\Tenant\Student;


use Illuminate\Database\Eloquent\Model;

class AttachStudentToParentAction
{
    public function execute(Model $student, string $parentUuid)
    {
        $student->update([
            'parent_id' => $parentUuid,
        ]);
    }
}
