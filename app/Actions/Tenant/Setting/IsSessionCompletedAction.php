<?php


namespace App\Actions\Tenant\Setting;


use App\Models\Tenant\ClassArm;

class IsSessionCompletedAction
{
    private array $checker = [];

    public function execute(): bool
    {
        ClassArm::all()->map(function ($classArm){
            $classArm->status != ClassArm::SESSION_COMPLETED_STATUS ? $this->checker [] = $classArm : null;
        });

        return ! (count($this->checker) > 0);
    }
}
