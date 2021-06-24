<?php


namespace App\Actions\Tenant\Result\Helpers;


use App\Models\Tenant\SchoolClass;
use Illuminate\Database\Eloquent\Collection;

class GetNewStructureFormat
{
    private Collection $initialFormats;

    public function execute(Collection $initialFormats): array
    {
        // :/ returns new c.a format and grading format with class name...

        $this->initialFormats = $initialFormats;

        return $this->getNewFormat();
    }

    private function getNewFormat(): array
    {
        $newCaFormats = [];

        foreach ( $this->initialFormats as $initialFormat ){

            $newCaFormats [] = [
                'uuid'        => $initialFormat->uuid,
                'name'        => str_replace('_', ' ', $initialFormat->name),
                'schoolClass' => $this->getSchoolClassName($initialFormat->school_class),
                'format'      => $initialFormat->meta,
            ];

        }

        return $newCaFormats;
    }

    private function getSchoolClassName(array $schoolClasses): array
    {
        $schoolClassesName = [];

        foreach ( $schoolClasses as $schoolClass ){
            $schoolClassesName [] = SchoolClass::query()->where('uuid', $schoolClass)->first()->class_name;
        }

        return $schoolClassesName;
    }
}
