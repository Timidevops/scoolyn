<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Broadsheet\CreateNewBroadsheetAction;
use App\Actions\Tenant\Result\Broadsheet\UpdateBroadsheetAction;
use App\Actions\Tenant\Result\Helpers\GetAcademicBroadsheet;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\Setting;
use App\Models\Tenant\StudentSubject;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AcademicBroadsheetsController extends Controller
{
    protected string $uuid;
    private $classSubject;

    public function index()
    {
        $teacherSubject = ClassSubject::all();

        if ( Auth::user()->hasRole(User::SUPER_ADMIN_USER) && $teacherSubject->isEmpty() ){

            Session::flash('warningFlash', 'Kindly add subject(s) to classes');

            return redirect()->route('listClass');
        }

        if ( $teacherSubject->isEmpty() ){
            abort(404);
        }

        $teacherSubject->load(['subject', 'schoolClass', 'classSectionType', 'classSectionCategoryType']);

        return view('Tenant.pages.result.academicBroadsheet.index', [
            'totalSubject' => $teacherSubject->count(),
            'subjects'     => $teacherSubject,
        ]);
    }

    public function create(string $uuid)
    {

        $this->classSubject = ClassSubject::whereUuid($uuid)->first();

        if( ! $this->classSubject ){
            abort(404);
        }

        $this->uuid = $uuid;

        // get c.a format for class
        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $this->classSubject->school_class_id)->first();

        if( ! $caFormat ){
            Session::flash('warningFlash', 'Cannot process request, kindly contact school admin.');
            return back();
        }

        $this->caFormat = collect($caFormat->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        // get students offering subject
        $studentSubjects = StudentSubject::query()->whereJsonContains('subjects', $this->classSubject->uuid)->get('student_id');

        $studentSubjects->load('student');

        //get students if subject teacher is for all class arms
        if($this->classSubject->class_arm){

            $this->students = collect($this->classSubject->class_arm)->map(function ($classArmId) use($studentSubjects){

                $subjectDetail['classArm'] = $classArmId;

                $subjectDetail['classSection'] = $this->classSubject->getClassArm($classArmId)->classSection;

                $subjectDetail['classSectionCategory'] = $this->classSubject->getClassArm($classArmId)->classSectionCategory;

                $subjectDetail['students'] = $studentSubjects->whereIn("student.class_arm", $classArmId)
                    ->load('student')->map(function ($student){
                        return $student->student;
                    });

                $subjectDetail['academicBroadsheets'] = null;

                $subjectDetail['broadsheetStatus'] = null;

                if( ! $this->classSubject->academicBroadsheet ){
                    return  $subjectDetail;
                }

                if($this->classSubject->academicBroadsheet()->where('class_arm', $classArmId)->exists()){

                    $academicBroadSheet = $this->classSubject->academicBroadsheet()->where('class_arm', $classArmId)->first();

                    $subjectDetail['academicBroadsheets'] = collect(collect($this->edit($academicBroadSheet))->get('broadsheets'));

                    $subjectDetail['caAssessmentStructureFormat'] = collect(collect($this->edit($academicBroadSheet))->get('caAssessmentStructure'));

                    $subjectDetail['gradeFormats'] = collect(collect( collect($this->edit($academicBroadSheet))->get('gradeFormat') )->get('meta'));

                    $subjectDetail['broadsheetStatus'] = $academicBroadSheet->status;
                }

                return $subjectDetail;


            })->values();

            //set subject placement to all class arms...
            $this->subjectPlacement = (bool) $this->classSubject->class_arm ? 'all' : '';
        }
        // get students if subject teacher is for only all class sections
        elseif ($this->classSubject->class_section_id && ! $this->classSubject->class_section_category_id){

            $this->students = $this->classSubject->getClassArmsByClassSectionId()->map(function ($classArm) use($studentSubjects){
                $subjectDetail['classArm'] = $classArm->uuid;

                $subjectDetail['classSection'] = $classArm->classSection;

                $subjectDetail['classSectionCategory'] = $classArm->classSectionCategory;

                $subjectDetail['students'] = $studentSubjects->whereIn("student.class_arm", $classArm->uuid)
                    ->load('student')->map(function ($student){
                        return $student->student;
                    });

                $subjectDetail['academicBroadsheets'] = null;

                $subjectDetail['broadsheetStatus'] = null;

                if( ! $this->classSubject->academicBroadsheet ){
                    return  $subjectDetail;
                }

                if($this->classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->exists()){
                    $academicBroadSheet = $this->classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->first();

                    $subjectDetail['academicBroadsheets'] = collect(collect($this->edit($academicBroadSheet))->get('broadsheets'));

                    $subjectDetail['caAssessmentStructureFormat'] = collect(collect($this->edit($academicBroadSheet))->get('caAssessmentStructure'));

                    $subjectDetail['gradeFormats'] = collect(collect( collect($this->edit($academicBroadSheet))->get('gradeFormat') )->get('meta'));

                    $subjectDetail['broadsheetStatus'] = $academicBroadSheet->status;
                }
                return $subjectDetail;
            });

            //set subject placement to all class arms...
            $this->subjectPlacement = 'all';// $this->classSubject->class_arm ? 'all' : '';

        }
        else{
            $this->students = $this->classSubject->getClassArmsByClassSectionCategoryId()->map(function ($classArm) use($studentSubjects){
                $subjectDetail['classArm'] = $classArm->uuid;

                $subjectDetail['classSection'] = $classArm->classSection;

                $subjectDetail['classSectionCategory'] = $classArm->classSectionCategory;

                $subjectDetail['students'] = $studentSubjects->whereIn("student.class_arm", $classArm->uuid)
                    ->load('student')->map(function ($student){
                        return $student->student;
                    });

                $subjectDetail['academicBroadsheets'] = null;

                $subjectDetail['broadsheetStatus'] = null;

                if( ! $this->classSubject->academicBroadsheet ){
                    return  $subjectDetail;
                }

                if($this->classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->exists()){
                    $academicBroadSheet = $this->classSubject->academicBroadsheet()->where('class_arm', $classArm->uuid)->first();

                    $subjectDetail['academicBroadsheets'] = collect(collect($this->edit($academicBroadSheet))->get('broadsheets'));

                    $subjectDetail['caAssessmentStructureFormat'] = collect(collect($this->edit($academicBroadSheet))->get('caAssessmentStructure'));

                    $subjectDetail['gradeFormats'] = collect(collect( collect($this->edit($academicBroadSheet))->get('gradeFormat') )->get('meta'));

                    $subjectDetail['broadsheetStatus'] = $academicBroadSheet->status;
                }
                return $subjectDetail;
            });

            $this->subjectPlacement = 'all';
        }

        return view('Tenant.pages.result.academicBroadsheet.create', [
            'caAssessmentStructure' => collect($this->caFormat),
            'students'              => $this->students,
            'classSubjectId'        => $uuid,
            'classSubject'          => $this->classSubject,
            'subjectPlacement'      => $this->subjectPlacement,
        ]);
    }

    public function store(Request $request, string $uuid)
    {
        $this->validate($request, [
            'classArm' => ['required'],
            'broadsheet.*.total' => ['required', 'min:0','max:100']
        ],[
            'broadsheet.*.total.required' => 'Kindly input fields',
            'broadsheet.*.total.min' => 'Kindly input fields',
            'broadsheet.*.total.max' => 'Kindly input correct fields',
        ]);

        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $classSubject = ClassSubject::whereUuid($uuid)->first(); //$teacher->subjectTeacher()->where('uuid', $uuid)->first();

        if( ! $classSubject ){
            Session::flash('errorFlash', 'Error processing request.');
            return back();
        }

        $academicBroadsheet = (new CreateNewBroadsheetAction())->execute($classSubject, [
            'meta'=> $request->input('broadsheet'),
            'class_arm' => $request->input('classArm'),
        ]);

        //add status
        $academicBroadsheet->setStatus(AcademicBroadSheet::CREATED_STATUS);

        Session::flash('successFlash', 'Broadsheet saved successfully!!!');

        return back();
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

    public function update(Request $request, string $uuid)
    {
        $this->validate($request, [
            'classArm' => ['required'],
            'broadsheet.*.total' => ['required','gt:0', 'min:1','max:100']
        ],[
            'broadsheet.*.total.required' => 'Kindly input fields',
            'broadsheet.*.total.gt' => 'Kindly input correct fields',
            'broadsheet.*.total.min' => 'Kindly input correct fields',
            'broadsheet.*.total.max' => 'Kindly input correct fields',
        ]);

        //@todo if user is the class teacher; update the broadsheet...
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $this->classSubject = ClassSubject::whereUuid($uuid)->withoutGlobalScope('teacher')->first(); //$teacher->subjectTeacher()->where('uuid', $uuid)->first();

        $academicBroadsheet = $this->classSubject->academicBroadsheet()
            ->where('class_arm', $request->input('classArm'))->first();

        if( ! $this->classSubject || ! $academicBroadsheet ){
            return back();
        }

        // save broadsheet
        (new UpdateBroadsheetAction())->execute($academicBroadsheet, [
            'meta'=> $request->input('broadsheet')
        ]);

        if( $request->has('submit') ){
            return $this->submitAcademicBroadsheet($this->classSubject, $academicBroadsheet);
        }

        Session::flash('successFlash', 'Broadsheet saved successfully!!!');

        return back();
    }

    private function submitAcademicBroadsheet(Model $classSubject, Model $academicBroadsheet)
    {
        // get c.a format for class
        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first();

        $academicBroadsheet->meta = [
            'caFormat'           => $caFormat->meta,
            'academicBroadsheet' => $academicBroadsheet->meta,
            ];

        $academicBroadsheet->save();

        // change status
        $academicBroadsheet->setStatus(AcademicBroadSheet::SUBMITTED_STATUS);

        Session::flash('successFlash', 'Broadsheet submitted successfully!!!');

        return back();
    }

}
