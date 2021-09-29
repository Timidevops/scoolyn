<?php


namespace App\Actions\Tenant\Fee;


use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class CreateNewSchoolFeeAction
{
    public function execute(array $input, array $feeStructures, array $classes, string $newSessionId = '')
    {
        $term = AcademicTerm::where('uuid', $input['term_id'])->get();
        $input['uuid'] = Uuid::uuid4();
        $input['academic_session_id'] = Setting::getCurrentAcademicSessionId();
        $input['term_id'] = $term->isNotEmpty()? $term->first()->uuid : null;

        if ( $newSessionId ){
            $input['academic_session_id'] = $newSessionId;
        }

        $schoolFee = SchoolFee::query()->create($input);

        //add fee structure
        foreach($feeStructures as $fee){
            (new CreateNewFeeStructureAction())->execute($schoolFee->uuid, camel_to_snake($fee));
        }

        if (  $newSessionId ){
            $firstTerm = AcademicTerm::find(1);

            $schoolFee = SchoolFee::query()
                ->withoutGlobalScope('academicSession')
                ->where('term_id', $firstTerm->uuid)
                ->where('academic_session_id', $newSessionId)
                ->first();
        }

        //add to classes
        foreach ($classes as $class){
            (new AttachFeeToSchoolClassAction())->execute($class, $schoolFee->uuid);
        }

        return $schoolFee;
    }
}
