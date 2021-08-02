<?php

namespace App\Http\Controllers\Tenant\ParentDomain\Result;

use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicResult;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\Parents;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function index(Request $request)
    {
        //@todo change to auth parent...
        $parent = Parents::find(1);

        $wards  =  $parent->ward()->get('uuid')->toArray();

        $results = AcademicResult::query()->where('student_id', $wards)->get();

        $results->load(['student', 'academicSession', 'academicTerm']);

        return view('livewire.tenant.parent-domain.result.index', [
            'results' => $results,
            'filterResult' => $request->has('ward') ? $request->has('ward') : '',
        ]);
    }

    public function single(string $uuid, string $studentId)
    {
        //@todo change to auth parent...
        $parent = Parents::find(1);

        $ward   = $parent->ward()->where('uuid', $studentId)->firstOrFail();

        $result = $ward->academicReport()->where('uuid', $uuid)->firstOrFail();

        $result->load(['student', 'academicSession', 'academicTerm', 'classArm']);

        $subjects = collect($result->subjects)->map(function ($subject, $key){
            return collect($subject)->put('subjectName', ClassSubject::whereUuid($key)->subject->subject_name);
        })->values();

        return view('Tenant.parentDomain.result.single', [
            'result' => $result,
            'subjects' => $subjects,
        ]);
    }
}
