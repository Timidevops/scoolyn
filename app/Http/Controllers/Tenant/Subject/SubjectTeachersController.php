<?php

namespace App\Http\Controllers\Tenant\Subject;

use App\Http\Controllers\Controller;
use App\Models\Tenant\SchoolSubject;

class SubjectTeachersController extends Controller
{
    public function index(string $uuid)
    {
        $subject = SchoolSubject::query()->where('slug', $uuid)->firstOrFail();

        $subjectTeachers = $subject->classSubject->load(['teacher', 'schoolClass','classSection','classSectionCategory']);

        return view('tenant.pages.subject.teacher', [
            'subject' => $subject,
            'subjectTeachers' => $subjectTeachers,
        ]);
    }

}
