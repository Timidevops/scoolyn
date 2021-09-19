<?php


namespace App\Actions\Tenant\Result\Broadsheet\Helper;


use App\Actions\Tenant\Result\Helpers\GetAcademicBroadsheet;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\AcademicGradingFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class GetClassSubjectBroadsheetAction
{
    private $classSubject;

    public function execute($classArm, $classSubject)
    {
        $this->classSubject = $classSubject;

        $subjectDetail = [];

        if($this->classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->exists()){
            $academicBroadSheets = $this->classSubject->academicBroadsheet()
                ->where('class_arm', $classArm->uuid)
                ->get();

            foreach ($academicBroadSheets as $key => $academicBroadSheet){
                //dd($academicBroadSheet);
                $subjectDetail[$key]['academicBroadsheets'] = collect(collect($this->edit($academicBroadSheet))->get('broadsheets'));

                $subjectDetail[$key]['caAssessmentStructureFormat'] = collect(collect($this->edit($academicBroadSheet))->get('caAssessmentStructure'));

                $subjectDetail[$key]['gradeFormats'] = collect(collect( collect($this->edit($academicBroadSheet))->get('gradeFormat') )->get('meta'));

                $subjectDetail[$key]['broadsheetStatus'] = $academicBroadSheet->status;
            }

        }

        return $subjectDetail;
    }

    private function edit(Model $academicBroadsheet)
    {
        // if status is submitted or approved :return _single page
        if( $academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS || $academicBroadsheet->status == AcademicBroadSheet::APPROVED_STATUS ){

            // get grade format for class
            $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $this->classSubject->school_class_id)->first();

            if( ! $gradeFormats ){
                Session::flash('warningFlash','Error completing request.');
                return redirect()->route('listAcademicBroadsheet');
            }

            $broadsheets = (new GetAcademicBroadsheet())->execute($academicBroadsheet->meta, true);


            return [
                'broadsheets' => $broadsheets,
                'gradeFormat' => $gradeFormats,
                'caAssessmentStructure' => collect( $academicBroadsheet->meta['caFormat'] ),
            ];

        }

        $generatedFormat = (bool) collect($academicBroadsheet->meta)->has('caFormat');

        $broadsheets = (new GetAcademicBroadsheet())->execute($academicBroadsheet->meta, $generatedFormat);

        // if status is not-approved :return _edit page with generated format
        if( $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){

            $broadsheets = (new GetAcademicBroadsheet())->execute($academicBroadsheet->meta, $generatedFormat);

        }

        return ['broadsheets' => $broadsheets];

    }
}
