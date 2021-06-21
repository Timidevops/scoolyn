<?php


namespace App\Actions\Tenant\Result\Broadsheet;


use Illuminate\Database\Eloquent\Model;

class UpdateBroadsheetAction
{
    public function execute(Model $classSubject, array $input)
    {
        $classSubject->academicBroadsheet()->update($input);
    }
}
