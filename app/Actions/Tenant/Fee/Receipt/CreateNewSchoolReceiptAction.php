<?php


namespace App\Actions\Tenant\Fee\Receipt;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewSchoolReceiptAction
{
    public function execute(Model $student, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $student->schoolReceipt()->create($input);
    }
}
