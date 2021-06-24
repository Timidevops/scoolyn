<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Helpers\GetAcademicBroadsheet;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\Student;
use App\Models\Tenant\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AcademicResultsController extends Controller
{
    public Model $classTeacher;

    public function index()
    {
        //@todo get auth teacher
        $teacher = Teacher::find(2);

        return view('Tenant.pages.result.academicResult.index', [
           'classTeacher'  => $teacher->classTeacher,
           'classSubjects' => $teacher->getClassSubjects()
        ]);

    }

    public function single(string $classSubjectId)
    {
        //@todo auth teacher
        $teacher = Teacher::find(2);

        $this->classTeacher = $teacher->classTeacher;

        $classSubject = ( collect($teacher->getClassSubjects())->whereIn('uuid', $classSubjectId) )->first();

        if( ! $classSubject || ! $classSubject->academicBroadsheet ){
            abort(404);
        }

        if( ! $classSubject->academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS || !  $classSubject->academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){
            abort(404);
        }

        // get grade format for class
        $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first();

        $broadsheets = collect( $classSubject->academicBroadsheet->meta['academicBroadsheet'] );

        // if class teacher is not all sections
        if( $this->classTeacher->class_section_id ){

            $broadsheets = $this->getBroadsheetPerClassSection($classSubject->academicBroadsheet->meta['academicBroadsheet']);

        }

        return view('Tenant.pages.result.academicResult.single', [
            'caAssessmentStructure' => collect( $classSubject->academicBroadsheet->meta['caFormat'] ),
            'gradeFormats'          => collect($gradeFormats->meta),
            'classSubject'          => $classSubject,
            'academicBroadsheets'   => collect( (new GetAcademicBroadsheet())->execute($broadsheets) ),
            'broadsheetStatus'      => (string) $classSubject->academicBroadsheet->status,
        ]);

    }

    public function approval(string $classSubjectId, Request $request){}

    private function getBroadsheetPerClassSection(array $academicBroadsheets)
    {
        $broadsheets = [];

        // filters students based on class teacher sections...
        foreach ( $academicBroadsheets as $key => $academicBroadsheet ){

            $student = Student::query()->where('uuid', $key)
                ->where('school_class_id', $this->classTeacher->school_class_id)
                ->where('class_section_id', $this->classTeacher->class_section_id)
                ->where('class_section_category_id', $this->classTeacher->class_section_category_id)->first();

            $broadsheets [$student->uuid] = $academicBroadsheets[$student->uuid];

        }

        return $broadsheets;
    }

}
