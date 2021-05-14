<?php


namespace App\Actions\Tenant\Subject;


use App\Models\Tenant\Subject;
use Ramsey\Uuid\Uuid;

class CreateNewSubjectAction
{
    public function execute(array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        Subject::query()->create($input);
    }
}
