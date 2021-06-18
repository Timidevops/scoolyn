<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Broadsheet\CreateNewBroadsheetAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentSubject;
use App\Models\Tenant\Subject;
use App\Models\Tenant\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AcademicBroadsheetsController extends Controller
{
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

        if(  $classSubject->academicBroadsheet ){
            //@todo fill the broadsheet table with saved meta column..

            $singleStudent =  $classSubject->academicBroadsheet;

            //dd( collect($singleStudent->meta)->get('111') );

            return true;
        }

        // get c.a format for class
        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first();

        // get students offering subject
        $students = StudentSubject::query()->whereJsonContains('subjects', $classSubject->uuid)->get();

        $students->load('student');

        return view('Tenant.testCreateAcademicBroadsheet', [
            'caAssessmentStructure' => collect($caFormat->meta),
            'students'              => $students,
            'classSubjectId'        => $uuid,
        ]);
    }

    public function store(Request $request, string $uuid)
    {
        //dd($request->all());
        //@todo change to auth:teacher
        $teacher = Teacher::find(1);

        $classSubject = $teacher->subjectTeacher->where('uuid', $uuid)->first();

        (new CreateNewBroadsheetAction())->execute($classSubject, [
            'meta'=> $request->input('broadsheet')
        ]);

        //@todo add status

        return back();
    }

}
