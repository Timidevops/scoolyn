<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Broadsheet\CreateNewBroadsheetAction;
use App\Actions\Tenant\Result\Broadsheet\UpdateBroadsheetAction;
use App\Actions\Tenant\Result\Helpers\GetAcademicBroadsheet;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentSubject;
use App\Models\Tenant\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AcademicBroadsheetsController extends Controller
{
    private $caFormat;
    private $students;
    protected string $uuid;

    public function index()
    {
        //@todo change to auth:teacher
        $teacher = Teacher::find(1);

        $teacherSubject = $teacher->subjectTeacher->load(['subject', 'schoolClass', 'classSectionType', 'classSectionCategoryType']);

        return view('Tenant.pages.result.academicBroadsheet.index', [
            'totalSubject' => $teacher->subjectTeacher->count(),
            'subjects'     => $teacherSubject,
        ]);
    }

    public function create(string $uuid)
    {
        //@todo change to auth:teacher
        $teacher = Teacher::find(1);

        $classSubject = $teacher->subjectTeacher->where('uuid', $uuid)->first();

        if( ! $classSubject ){
            abort(404);
        }

        $this->uuid = $uuid;

        // get c.a format for class
        $this->caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first();

        // get students offering subject
        $this->students = StudentSubject::query()->whereJsonContains('subjects', $classSubject->uuid)->get();

        $this->students->load('student');

        if(  $classSubject->academicBroadsheet ){

            //$singleStudent =  $classSubject->academicBroadsheet;

            //dd( collect($singleStudent->meta)->get('111') );

            return $this->edit($classSubject);
        }

        return view('Tenant.pages.result.academicBroadsheet.create', [
            'caAssessmentStructure' => collect($this->caFormat->meta),
            'students'              => $this->students,
            'classSubjectId'        => $uuid,
            'classSubject'          => $classSubject,
        ]);
    }

    public function store(Request $request, string $uuid)
    {
        //@todo change to auth:teacher
        $teacher = Teacher::find(1);

        $classSubject = $teacher->subjectTeacher->where('uuid', $uuid)->first();

        $academicBroadsheet = (new CreateNewBroadsheetAction())->execute($classSubject, [
            'meta'=> $request->input('broadsheet')
        ]);

        //add status
        $academicBroadsheet->setStatus(AcademicBroadSheet::CREATED_STATUS);

        return back();
    }

    private function edit(Model $classSubject)
    {

        // if status is submitted or approved :return _single page
        if( $classSubject->academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS || $classSubject->academicBroadsheet->status == AcademicBroadSheet::APPROVED_STATUS ){

            // get grade format for class
            $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first();

            $broadsheets = (new GetAcademicBroadsheet())->execute($classSubject->academicBroadsheet->meta, true);

            return view('Tenant.pages.result.academicBroadsheet.single', [
                'caAssessmentStructure' => collect( $classSubject->academicBroadsheet->meta['caFormat'] ),
                'gradeFormats'          => collect($gradeFormats->meta),
                'classSubject'          => $classSubject,
                'academicBroadsheets'   => collect($broadsheets),
                'broadsheetStatus'      => (string) $classSubject->academicBroadsheet->status,
            ]);
        }

        $broadsheets = (new GetAcademicBroadsheet())->execute($classSubject->academicBroadsheet->meta);

        // if status is not-approved :return _edit page with generated format
        if( $classSubject->academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){

            $broadsheets = (new GetAcademicBroadsheet())->execute($classSubject->academicBroadsheet->meta, true);

        }

        return view('Tenant.pages.result.academicBroadsheet.edit', [
            'caAssessmentStructure' => collect($this->caFormat->meta),
            'classSubjectId'        => $this->uuid,
            'classSubject'          => $classSubject,
            'academicBroadsheets'   => collect($broadsheets),
        ]);
    }

    public function update(Request $request, string $uuid)
    {
        //@todo change to auth:teacher
        $teacher = Teacher::find(1);

        $classSubject = $teacher->subjectTeacher->where('uuid', $uuid)->first();

        if( ! $classSubject ){
            abort(404);
        }

        // save broadsheet
        (new UpdateBroadsheetAction())->execute($classSubject, [
            'meta'=> $request->input('broadsheet')
        ]);

        if( $request->has('submit') ){
            return $this->submitAcademicBroadsheet($classSubject);
        }

        return back();
    }

    private function submitAcademicBroadsheet(Model $classSubject)
    {
        // get c.a format for class
        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first();

        $classSubject->academicBroadsheet->meta = [
            'caFormat'           => $caFormat->meta,
            'academicBroadsheet' => $classSubject->academicBroadsheet->meta,
            ];

        // save academic broadsheet as generated format
        $classSubject->academicBroadsheet->save();

        // change status
        $classSubject->academicBroadsheet->setStatus(AcademicBroadSheet::SUBMITTED_STATUS);

        return back();
    }

}
