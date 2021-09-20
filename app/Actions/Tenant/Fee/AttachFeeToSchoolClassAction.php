<?php


namespace App\Actions\Tenant\Fee;


use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\SchoolClass;
use Ramsey\Uuid\Uuid;

class AttachFeeToSchoolClassAction
{
    public function execute(string $schoolClassId, string $schoolFeeId)
    {
        $schoolClass = SchoolClass::query()->where('uuid', $schoolClassId)->get();

        if($schoolClass->isEmpty()){
            return;
        }

        $schoolClass->first()->update([
            'school_fees_id' => $schoolFeeId,
        ]);
    }
}
