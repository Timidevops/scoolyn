<?php

namespace App\Http\Controllers\Tenant\Subject;

use App\Actions\Tenant\Subject\SubjectTeacher\CreateNewSubjectTeacherAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassSectionCategoryType;
use App\Models\Tenant\ClassSectionType;
use App\Models\Tenant\Subject;
use Illuminate\Http\Request;

class SubjectTeachersController extends Controller
{
    public function index(string $uuid)
    {
        $subject = Subject::query()->where('slug', $uuid)->firstOrFail();

        $subjectTeachers = $subject->subjectTeacher->load(['teacher','classSection','classSectionCategory']);

        return view('tenant.pages.subject.teacher', [
            'subject' => $subject,
            'subjectTeachers' => $subjectTeachers,
            'classSectionCategoryType' => ClassSectionCategoryType::query()->get(['uuid','category_name']),
            'classSectionType'         => ClassSectionType::query()->get(['uuid','section_name']),
        ]);
    }

    public function store(Request $request)
    {
        $class = ClassSection::query()->where('uuid', '=', $request->input('classSection'))->first();

        if( $request->input('classSectionCategory') ){
            $class = ClassSectionCategory::query()->where('uuid', '=', $request->input('classSectionCategory'))->first();
        }

        (new CreateNewSubjectTeacherAction())->execute($class, [
            'teacher_id' => $request->input('teacher'),
            'subject_id' => $request->input('subject'),
        ]);

        return redirect('/');
    }
}
