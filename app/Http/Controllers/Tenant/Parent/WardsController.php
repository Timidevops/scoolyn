<?php

namespace App\Http\Controllers\Tenant\Parent;

use App\Actions\Tenant\Student\AttachStudentToParentAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WardsController extends Controller
{
    public function index(string $uuid)
    {
        $parent = StudentParent::query()->where('uuid', $uuid)->firstOrFail();

        $wards =  $parent->ward->load(['classArm.schoolClass', 'classArm.classSection', 'classArm.classSectionCategory']);

        return view('tenant.pages.parent.ward.index', [
            'totalWards' => $parent->ward()->count(),
            'wards'=> $wards,
            'parent' => $parent,
        ]);
    }

    public function create(string $uuid)
    {
        $parent = StudentParent::query()->where('uuid', $uuid)->firstOrFail();

        $dummyParent = StudentParent::query()->withoutGlobalScope('dummyParent')->find(1);

        $students = Student::all()->filter(function ($student) use($dummyParent){
            return $student->parent_id == $dummyParent->uuid;
        })->load(['classArm.schoolClass', 'classArm.classSection', 'classArm.classSectionCategory']);

        return view('tenant.pages.parent.ward.create', [
            'parent' => $parent,
            'students' => $students,
        ]);
    }

    public function store(string $uuid, Request $request)
    {
        $this->validate($request, [
            'students' => ['required', 'array', 'min:1'],
            'students.*' => ['exists:'.config('env.tenant.tenantConnection').'.students,uuid'],
        ]);

        $parent = StudentParent::query()->where('uuid', $uuid)->first();

        if ( ! $parent ){
            Session::flash('errorFlash', 'Error processing request.');
            return back();
        }

        $students = collect($request->input('students'))->unique()->values();

        foreach ( $students as $student ){
            $student = Student::whereUuid($student);

            (new AttachStudentToParentAction)->execute($student, $parent->uuid);
        }

        Session::flash('successFlash', 'Ward added successfully!!!');

        return redirect()->route('listParentWard',$parent->uuid);
    }
}
