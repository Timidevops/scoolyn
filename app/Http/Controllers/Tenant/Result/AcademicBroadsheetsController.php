<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Broadsheet\CreateNewBroadsheetAction;
use App\Actions\Tenant\Result\Broadsheet\UpdateBroadsheetAction;
use App\Actions\Tenant\Result\Helpers\GetAcademicBroadsheet;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentSubject;
use App\Models\Tenant\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AcademicBroadsheetsController extends Controller
{
    private $caFormat;
    private Collection $students;
    private string $subjectPlacement;
    protected string $uuid;
    private Model $classSubject;

    public function index()
    {
        //@todo change to auth:teacher
        $teacher = Teacher::find(12);

        $teacherSubject = $teacher->subjectTeacher->load(['subject', 'schoolClass', 'classSectionType', 'classSectionCategoryType']);

        return view('Tenant.pages.result.academicBroadsheet.index', [
            'totalSubject' => $teacher->subjectTeacher->count(),
            'subjects'     => $teacherSubject,
        ]);
    }

    public function create(string $uuid)
    {
        //@todo change to auth:teacher
        $teacher = Teacher::find(12);
        //dd($teacher->subjectTeacher);
        $this->classSubject = $teacher->subjectTeacher()->where('uuid', $uuid)->firstOrFail();

        $this->uuid = $uuid;

        // get c.a format for class
        $this->caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $this->classSubject->school_class_id)->first();

        // get students offering subject
        $studentSubjects = StudentSubject::query()->whereJsonContains('subjects', $this->classSubject->uuid)->get('student_id');

        $studentSubjects->load('student');

        //dd($student->first()->student->classArm);



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

                //dd(collect(collect($this->edit($academicBroadSheet))->get('gradeFormat'))['meta']);

                return $subjectDetail;

//                if( ! $classArmInstance->classSectionCategory ){
//
//                    $subjectDetail['students'] = $studentSubjects->whereIn("student.class_arm", $classArm)
//                        ->load('student')->map(function ($student){
//                            return $student->student;
//                        });
//
//                    return $subjectDetail;
//                }

                //return $subjectDetail;

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

        //dd($this->students);


//        if( $this->classSubject->academicBroadsheet ){
//
//            //$singleStudent =  $this->classSubject->academicBroadsheet;
//
//            //dd( collect($singleStudent->meta)->get('111') );
//
//            return $this->edit($this->classSubject);
//        }

        return view('Tenant.pages.result.academicBroadsheet.create', [
            'caAssessmentStructure' => collect($this->caFormat->meta),
            'students'              => $this->students,
            'classSubjectId'        => $uuid,
            'classSubject'          => $this->classSubject,
            'subjectPlacement'      => $this->subjectPlacement,
        ]);
    }

    public function store(Request $request, string $uuid)
    {

        //@todo change to auth:teacher
        $teacher = Teacher::find(12);

        $classSubject = $teacher->subjectTeacher()->where('uuid', $uuid)->first();

        if( ! $classSubject ){
            return back();
        }

        $academicBroadsheet = (new CreateNewBroadsheetAction())->execute($classSubject, [
            'meta'=> $request->input('broadsheet'),
            'class_arm' => $request->input('classArm'),
        ]);

        //add status
        $academicBroadsheet->setStatus(AcademicBroadSheet::CREATED_STATUS);

        return back();
    }

    private function edit(Model $academicBroadsheet)
    {

        // if status is submitted or approved :return _single page
        if( $academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS || $academicBroadsheet->status == AcademicBroadSheet::APPROVED_STATUS ){

            // get grade format for class
            $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $this->classSubject->school_class_id)->first();

            $broadsheets = (new GetAcademicBroadsheet())->execute($academicBroadsheet->meta, true);

            return [
                'broadsheets' => $broadsheets,
                'gradeFormat' => $gradeFormats,
                'caAssessmentStructure' => collect( $academicBroadsheet->meta['caFormat'] ),
            ];

            return view('Tenant.pages.result.academicBroadsheet.single', [
                'caAssessmentStructure' => collect( $this->classSubject->academicBroadsheet->meta['caFormat'] ),
                'gradeFormats'          => collect($gradeFormats->meta),
                'classSubject'          => $this->classSubject,
                'academicBroadsheets'   => collect($broadsheets),
                'broadsheetStatus'      => (string) $this->classSubject->academicBroadsheet->status,
            ]);
        }

        $generatedFormat = collect($academicBroadsheet->meta)->has('caFormat');
        $broadsheets = (new GetAcademicBroadsheet())->execute($academicBroadsheet->meta, $generatedFormat);

        // if status is not-approved :return _edit page with generated format
        if( $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){

            $broadsheets = (new GetAcademicBroadsheet())->execute($academicBroadsheet->meta, $generatedFormat);

        }

        return ['broadsheets' => $broadsheets];

        return view('Tenant.pages.result.academicBroadsheet.edit', [
            'caAssessmentStructure' => collect($this->caFormat->meta),
            'classSubjectId'        => $this->uuid,
            'classSubject'          => $this->classSubject,
            'academicBroadsheets'   => collect($broadsheets),
            'broadsheetStatus'      => (string) $this->classSubject->academicBroadsheet->status,
        ]);
    }

    public function update(Request $request, string $uuid)
    {
        //@todo change to auth:teacher
        $teacher = Teacher::find(12);

        $this->classSubject = $teacher->subjectTeacher()->where('uuid', $uuid)->first();

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

        // save academic broadsheet as generated format
        $academicBroadsheet->save();

        // change status
        $academicBroadsheet->setStatus(AcademicBroadSheet::SUBMITTED_STATUS);

        return back();
    }

}
