<?php


namespace App\Actions\Tenant\AcademicSession;


use App\Models\Tenant\AcademicSession;
use Ramsey\Uuid\Uuid;

class CreateNewAcademicSessionAction
{
    public function execute(array $input)
    {
        $input['input'] = Uuid::uuid4();
        AcademicSession::query()->create($input);
    }
}
