<?php


namespace App\Actions\Tenant\User;


use App\Actions\Tenant\Teacher\Designation\RemoveTeacherAsClassTeacherAction;
use App\Actions\Tenant\Teacher\Designation\RemoveTeacherAsSubjectTeacher;
use App\Models\Tenant\StudentParent;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;

class SuspendUserAction
{
    public function execute(Model $model)
    {
        if($model instanceof Teacher){
            if($model->user->hasAnyRole([User::SUBJECT_TEACHER_USER, User::CLASS_TEACHER_USER])) {
                (new RemoveTeacherAsClassTeacherAction)->execute($model->user);
                (new RemoveTeacherAsSubjectTeacher)->execute($model->user);
            }
            return $this->suspendUser($model->user);
        }

        if($model instanceof StudentParent){
            return $this->suspendUser($model->user);
        }

        return $this->suspendUser($model);
    }

    private function suspendUser(User $user) : bool
    {
        if($user->isSuspended()){
            return true;
        }

        $user->suspend();
        return $user->isSuspended();
    }
}
