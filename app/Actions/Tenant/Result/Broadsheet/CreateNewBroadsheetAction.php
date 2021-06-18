<?php


namespace App\Actions\Tenant\Result\Broadsheet;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewBroadsheetAction
{
    public function execute(Model $classSubject, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $classSubject->academicBroadsheet()->create($input);
    }
}
