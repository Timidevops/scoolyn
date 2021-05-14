<?php


namespace App\Actions\Tenant\Result\AcademicReport;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewAcademicReportAction
{
    public function execute(Model $student, array $input)
    {
        $input['uuid'] = Uuid::uuid4();
        $student->academicReport()->create($input);
    }
}
