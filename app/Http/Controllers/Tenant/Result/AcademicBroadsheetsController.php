<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Broadsheet\CreateNewBroadsheetAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use App\Models\Tenant\Teacher;
use Illuminate\Http\Request;

class AcademicBroadsheetsController extends Controller
{
    public function index()
    {
        //@todo change to auth:teacher
        $teacher = Teacher::find(1);

        $teacherSubject = $teacher->subjectTeacher->load(['subject', 'schoolClass', 'classSection', 'classSectionCategory']);

        return view('Tenant.pages.result.academicBroadsheet.index', [
            'totalSubject' => $teacher->subjectTeacher->count(),
            'subjects' => $teacherSubject,
        ]);
    }

    public function create(string $subject, string $class, Request $request)
    {
        if(! $request['class-section'] && !$request['class-section-category'] && $request['class-section'] != 'all-section'){
            abort(404);
        }

        $subject = Subject::query()->where('slug', $subject)->firstOrFail();
        $class   = SchoolClass::query()->where('slug', $class)->firstOrFail();

        //@todo change to auth:teacher
        $teacher = Teacher::find(1);

        //@
        //todo remove Subject Teacher ::  Access via Class Subject ++ Teacher ID to Class Subject
        // On Subject Teacher Page, select class from class subject, remove class sections dropdown...
        // Below code not fully valid
        // In student subject add ++ class_subject_uuid as JSON subject_id.

        if( $request['class-section'] && $request['class-section'] != 'all-section' ){
            $subjectTeacher = $teacher->subjectTeacher
                ->whereIn('subject_id', $subject->uuid)
                ->whereIn('school_class_id', $class->uuid)
                ->whereIn('class_section_id', $request['class-section']);

            $classSubject = ClassSubject::query()
                ->where('subject_id', $subjectTeacher->first()->subject_id)
                ->where('school_class_id', $subjectTeacher->first()->schoolClass->uuid)
                ->where('class_section_id', $subjectTeacher->first()->classSection->laravel_through_key)->first();
        }
        elseif ($request['class-section-category']){
            $subjectTeacher = $teacher->subjectTeacher
                ->whereIn('subject_id', $subject->uuid)
                ->whereIn('school_class_id', $class->uuid)
                ->whereIn('class_section_category_id', $request['class-section-category']);

            $classSubject = ClassSubject::query()
                ->where('subject_id', $subjectTeacher->first()->subject_id)
                ->where('school_class_id', $subjectTeacher->first()->schoolClass->uuid)
                ->where('class_section_category_id', $subjectTeacher->first()->classSectionCategory->laravel_through_key)->first();
        }
        else{
            $subjectTeacher = $teacher->subjectTeacher
                ->whereIn('subject_id', $subject->uuid)
                ->whereIn('school_class_id', $class->uuid);

            $classSubject = ClassSubject::query()
                ->where('subject_id', $subjectTeacher->first()->subject_id)
                ->where('school_class_id', $subjectTeacher->first()->schoolClass->uuid)->first();
        }

        if( ! $subjectTeacher->first() || ! $classSubject){
            abort(404);
        }

        dd($classSubject);


//        if( $request['class-section'] && $request['class-section'] != 'all-section' ){
//            $classSubject = ClassSubject::query()->where('slug', $request['class-section'])->first();
//        }
//        elseif ($request['class-section-category']){
//            $classSubject = ClassSectionCategory::query()->first();
//        }

        $caAssessmentStructureArray = ContinuousAssessmentStructure::query()->first('meta')->toArray();
        return view('Tenant.testCreateAcademicBroadsheet', [
            'caAssessmentStructure' => collect($caAssessmentStructureArray['meta']),
        ]);
    }

    public function store(Request $request)
    {
        dd($request->dd());
        $class = ClassSection::query()->where('uuid', '=', $request->input('classSection'))->first();

        if( $request->input('classSectionCategory') ){
            $class = ClassSectionCategory::query()->where('uuid', '=', $request->input('classSectionCategory'))->first();
        }

        (new CreateNewBroadsheetAction())->execute($class, [
            'subject_id' => $request->input('subject'),
            'teacher_id' => $request->input('teacher'),
            'meta'       => $request->input('broadsheet')
        ]);

        //@todo add status

        return redirect('/');
    }
}
