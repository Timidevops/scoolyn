<?php


namespace App\Actions\Tenant\User;


use App\Actions\Tenant\Teacher\Designation\RemoveTeacherAsClassTeacherAction;
use App\Actions\Tenant\Teacher\Designation\RemoveTeacherAsSubjectTeacher;
use App\Models\Tenant\StudentParent;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;

class UnSuspendUserAction
{
    public function execute(Model $model)
    {
        if($model instanceof Teacher){
            return $this->unSuspendUser($model->user);
        }

        if($model instanceof StudentParent){
            return $this->unSuspendUser($model->user);
        }

        return $this->unSuspendUser($model);
    }

    private function unSuspendUser(User $user) : bool
    {
        if(! $user->isSuspended()){
            return true;
        }

        $user->unsuspend();
        return ! $user->isSuspended();
    }
}
