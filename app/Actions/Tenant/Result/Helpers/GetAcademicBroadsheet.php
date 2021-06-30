<?php


namespace App\Actions\Tenant\Result\Helpers;


use App\Models\Tenant\Student;

class GetAcademicBroadsheet
{
    private array $meta;
    private bool $generatedFormat;

    public function execute(array $meta, bool $generatedFormat = false): array
    {
        // :/ returns formatted academic broadsheet with student name...

        $this->meta = $meta;

        $this->generatedFormat = $generatedFormat;

        return $this->getAcademicBroadsheet();
    }

    private function getAcademicBroadsheet(): array
    {
        $broadsheets = [];

        $meta = $this->generatedFormat ? collect($this->meta['academicBroadsheet']) : collect($this->meta);

        for ( $int = 0; $int < count($meta); $int++ ){

            $student = Student::query()->where('uuid',$meta->keys()[$int])->first();


            $broadsheets [] = [
                'studentId'   => $meta->keys()[$int],
                'studentName' => "{$student->first_name} {$student->last_name}",
                'broadsheet'  => $meta->values()[$int],
            ];

        }

        return $broadsheets;
    }
}
