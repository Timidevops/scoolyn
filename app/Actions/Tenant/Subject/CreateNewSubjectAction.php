<?php


namespace App\Actions\Tenant\Subject;

use App\Models\Tenant\SchoolSubject;
use Ramsey\Uuid\Uuid;

class CreateNewSubjectAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        SchoolSubject::query()->create($input);
    }
}
