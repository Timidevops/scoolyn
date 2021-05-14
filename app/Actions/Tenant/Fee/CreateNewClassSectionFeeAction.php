<?php


namespace App\Actions\Tenant\Fee;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewClassSectionFeeAction
{
    public function execute(Model $classSection, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $classSection->classFee()->create($input);
    }
}
