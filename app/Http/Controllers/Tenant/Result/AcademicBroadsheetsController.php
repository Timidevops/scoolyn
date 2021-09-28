<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Broadsheet\CreateNewBroadsheetAction;
use App\Actions\Tenant\Result\Broadsheet\Helper\GetClassSubjectBroadsheetAction;
use App\Actions\Tenant\Result\Broadsheet\Helper\SumCAScorePerStudentAction;
use App\Actions\Tenant\Result\Broadsheet\UpdateBroadsheetAction;
use App\Actions\Tenant\Result\Helpers\GetAcademicBroadsheet;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\ReportCardBreakdownFormat;
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

        if( ! ReportCardBreakdownFormat::checkIfBroadSheetReportCardIsNext($this->classSubject) ){

            Session::flash('warningFlash', 'Previous broadsheet record needed, kindly contact school admin.');

            return back();
        }

        $this->uuid = $uuid;

        // get c.a format for class
        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $this->classSubject->school_class_id)->first();

        if( ! $caFormat ){
            Session::flash('warningFlash', 'Cannot process request, C.A format missing kindly contact school admin.');
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

                $subjectDetail['previousReportCard'] = null;

                $classArm = ClassArm::withoutGlobalScope('teacher')->whereUuid($classArmId)->first();

                if( ! $this->classSubject->academicBroadsheet()->where('report_card', Setting::getCurrentCardBreakdownFormat())->exists() ){
                    if ( $this->classSubject->academicBroadsheet ){

                        $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                        $subjectDetail = collect($subjectDetail)->put('previousReportCard', $classSubjectBroadsheet);

                    }

                    return  $subjectDetail;
                }

                if ( $this->classSubject->academicBroadsheet ){

                    $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                    array_splice($classSubjectBroadsheet, ReportCardBreakdownFormat::currentFormatPlacementId(),1);

                    $subjectDetail = collect($subjectDetail)->put('previousReportCard', $classSubjectBroadsheet);

                }

                $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                $currentReportExists = $this->classSubject->academicBroadsheet()->where('report_card', ReportCardBreakdownFormat::getPreviousReportCard())->exists();

                $classSubjectBroadsheet = $currentReportExists ? $classSubjectBroadsheet[ReportCardBreakdownFormat::currentFormatPlacementId()] : $classSubjectBroadsheet[0];

                return collect($subjectDetail)->merge($classSubjectBroadsheet);


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

                $subjectDetail['previousReportCard'] = null;


                if ( ! $this->classSubject->academicBroadsheet()->where('report_card', Setting::getCurrentCardBreakdownFormat())->exists() ){

                    if ( $this->classSubject->academicBroadsheet ){

                        $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                        $subjectDetail = collect($subjectDetail)->put('previousReportCard', $classSubjectBroadsheet);

                    }

                    return  $subjectDetail;
                }

                if ( $this->classSubject->academicBroadsheet ){

                    $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                    array_splice($classSubjectBroadsheet, ReportCardBreakdownFormat::currentFormatPlacementId(),1);

                    $subjectDetail = collect($subjectDetail)->put('previousReportCard', $classSubjectBroadsheet);

                }

                $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                $currentReportExists = $this->classSubject->academicBroadsheet()->where('report_card', ReportCardBreakdownFormat::getPreviousReportCard())->exists();

                $classSubjectBroadsheet = $currentReportExists ? $classSubjectBroadsheet[ReportCardBreakdownFormat::currentFormatPlacementId()] : $classSubjectBroadsheet[0];

                return collect($subjectDetail)->merge($classSubjectBroadsheet);

            });
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

                $subjectDetail['previousReportCard'] = null;

                if( ! $this->classSubject->academicBroadsheet()->where('report_card', Setting::getCurrentCardBreakdownFormat())->exists() ){
                    if ( $this->classSubject->academicBroadsheet ){

                        $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                        $subjectDetail = collect($subjectDetail)->put('previousReportCard', $classSubjectBroadsheet);

                    }

                    return  $subjectDetail;
                }

                if ( $this->classSubject->academicBroadsheet ){

                    $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                    array_splice($classSubjectBroadsheet, ReportCardBreakdownFormat::currentFormatPlacementId(),1);

                    $subjectDetail = collect($subjectDetail)->put('previousReportCard', $classSubjectBroadsheet);

                }

                $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($classArm, $this->classSubject);

                $currentReportExists = $this->classSubject->academicBroadsheet()->where('report_card', ReportCardBreakdownFormat::getPreviousReportCard())->exists();

                $classSubjectBroadsheet = $currentReportExists ? $classSubjectBroadsheet[ReportCardBreakdownFormat::currentFormatPlacementId()] : $classSubjectBroadsheet[0];

                return collect($subjectDetail)->merge($classSubjectBroadsheet);
            });

        }

        //dd($this->students);

        return view('Tenant.pages.result.academicBroadsheet.create', [
            'caAssessmentStructure' => collect($this->caFormat),
            'students'              => $this->students,
            'classSubjectId'        => $uuid,
            'classSubject'          => $this->classSubject,
        ]);
    }

    public function store(Request $request, string $uuid)
    {
        $this->validate($request, [
            'classArm' => ['required'],
        ],[
            'classArm.required' => 'Error submitting, try again',
        ]);

        $classSubject = ClassSubject::whereUuid($uuid)->first();

        if( ! $classSubject ){
            Session::flash('errorFlash', 'Error processing request.');
            return back();
        }

        // get c.a format for class
        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first();

        $currentCAFormat = collect($caFormat->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        $broadsheet = (new SumCAScorePerStudentAction)->execute($request->input('broadsheet'), $currentCAFormat['caFormat']);

        if ( ! $broadsheet ){
            Session::flash('Broadsheet inputs not entered correctly...');
            return back();
        }


        $academicBroadsheet = (new CreateNewBroadsheetAction())->execute($classSubject, [
            'meta'=> $broadsheet,
            'class_arm' => $request->input('classArm'),
            'report_card' => Setting::getCurrentCardBreakdownFormat(),
        ]);

        //add status
        $academicBroadsheet->setStatus(AcademicBroadSheet::CREATED_STATUS);

        Session::flash('successFlash', 'Broadsheet saved successfully!!!');

        return back();
    }

    public function update(Request $request, string $uuid)
    {
        $this->validate($request, [
            'classArm' => ['required'],
        ],[
            'classArm.required' => 'Error submitting, try again',
        ]);

        $this->classSubject = ClassSubject::whereUuid($uuid)->withoutGlobalScope('teacher')->first();

        $academicBroadsheet = $this->classSubject->academicBroadsheet()
            ->where('class_arm', $request->input('classArm'))
            ->where('report_card', Setting::getCurrentCardBreakdownFormat())
            ->first();

        if( ! $this->classSubject || ! $academicBroadsheet ){
            return back();
        }

        // get c.a format for class
        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $this->classSubject->school_class_id)->first();

        $currentCAFormat = collect($caFormat->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        $broadsheet = (new SumCAScorePerStudentAction)->execute($request->input('broadsheet'), $currentCAFormat['caFormat']);

        if ( ! $broadsheet ){
            Session::flash('Broadsheet inputs not entered correctly...');
            return back();
        }

        // save broadsheet
        (new UpdateBroadsheetAction())->execute($academicBroadsheet, [
            'meta'=> $broadsheet
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

        $reportCardFormat = collect($caFormat->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        $academicBroadsheet->meta = [
            'caFormat'           => $reportCardFormat['caFormat'],
            'academicBroadsheet' => $academicBroadsheet->meta,
            ];

        $academicBroadsheet->save();

        // change status
        $academicBroadsheet->setStatus(AcademicBroadSheet::SUBMITTED_STATUS);

        Session::flash('successFlash', 'Broadsheet submitted successfully!!!');

        return back();
    }

}
