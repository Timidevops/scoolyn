<?php


namespace App\Actions\Tenant\AcademicTerm;


use App\Models\Tenant\AcademicTerm;
use Ramsey\Uuid\Uuid;

class CreateNewAcademicTermAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        AcademicTerm::query()->create($input);
    }
}
