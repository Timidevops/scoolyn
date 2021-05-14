<?php


namespace App\Actions\Tenant\Result\Broadsheet;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewBroadsheetAction
{
    public function execute(Model $model, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $model->schoolClass()->create($input);
    }
}
