<?php


namespace App\Actions\Tenant\Fee;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewSchoolFeeAction
{
    public function execute(Model $student, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $student->schoolFee()->create($input);
    }
}
