<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Helpers\GetAcademicBroadsheet;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\Student;
use App\Models\Tenant\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AcademicResultsController extends Controller
{
    private $classArm;
    private $subjectBroadsheet;

    public function index()
    {
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $classArm = $teacher->classArm;

        $classArm->load(['schoolClass', 'classSection', 'classSectionCategory']);

        return view('Tenant.pages.result.academicResult.index', [
           'totalClass'    => count($classArm),
            'classArm'     => $classArm,
        ]);

    }

    public function single(string $classArmId)
    {
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $classArm = $teacher->classArm()->where('uuid', $classArmId)->firstOrFail();

        $classSubject = $classArm->classSubject->filter(function ($classSubject) use($classArm){

            if($classSubject->class_arm){

                return $classSubject->whereJsonContains('class_arm', $classArm->uuid);
            }
            elseif ($classSubject->class_section_id && ! $classSubject->class_section_category_id){
                return  $classSubject->class_section_id == $classArm->class_section_id;
            }

            return $classSubject->class_section_id == $classArm->class_section_id && $classSubject->class_section_category_id == $classArm->class_section_category_id;
        });

        return view('Tenant.pages.result.academicResult.single', [
            'classArm' => $classArm,
            'classSubjects' => $classSubject,
        ]);
    }

    public function singleSubject(string $classArmId, string $classSubjectId)
    {
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $this->classArm = $teacher->classArm()->where('uuid', $classArmId)->first();

        if( ! $this->classArm ){
            abort(404);
        }

        $classSubject = ClassSubject::whereUuid($classSubjectId);


        $academicBroadsheet = AcademicBroadSheet::query()
            ->where('class_arm', $classArmId)
            ->where('class_subject_id', $classSubjectId)->first();


        ! $academicBroadsheet ? abort(404) : null;

        if( ! $academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS || !  $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){
            abort(404);
        }

        if( $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){
            return $this->edit($classSubject, $academicBroadsheet);
        }

        // get grade format for class
        $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $this->classArm->school_class_id)->first();

        $this->subjectBroadsheet = collect( $academicBroadsheet->meta['academicBroadsheet'] );

        return view('Tenant.pages.result.academicResult.singleSubject', [
            'caAssessmentStructureFormat' => collect( $academicBroadsheet->meta['caFormat'] ),
            'gradeFormats'          => collect($gradeFormats->meta),
            'classSubject'          => $classSubject,
            'classSubjectId'        => $classSubject->uuid,
            'academicBroadsheets'   => collect( $this->getStudentBroadsheets() ),
            'broadsheetStatus'      => (string) $academicBroadsheet->status,
            'classArm'              => $this->classArm,
        ]);

    }

    /**
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|Collection
     */
    private function getStudentBroadsheets()
    {
        $isClassTeacherPerSection = $this->classArm->class_section_id
            ? $this->classArm->students
            : $this->subjectBroadsheet->keys();

        $subjectBroadsheet = $this->subjectBroadsheet;

        $students = Student::query()->whereIn('uuid', $isClassTeacherPerSection)->get(['uuid','first_name','last_name']);

        return $students->map(function ($item)use($subjectBroadsheet){

            $item['studentName'] = "{$item->first_name} {$item->last_name}";

            $item['studentId']   = $item->uuid;

            $item['broadsheet']  = collect($subjectBroadsheet)->get($item->uuid);

            return collect($item)->except(['first_name', 'last_name', 'uuid'])->toArray();
        });
    }

    private function edit( $classSubject, $academicBroadsheet)
    {
        $generatedFormat = collect($academicBroadsheet->meta)->has('caFormat');

        $broadsheets = (new GetAcademicBroadsheet())->execute($academicBroadsheet->meta, $generatedFormat);

        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first() ;

        return view('Tenant.pages.result.academicResult.singleSubject', [
            'caAssessmentStructure' => collect( $caFormat->meta ),
            'classSubject'          => $classSubject,
            'classSubjectId'        => $classSubject->uuid,
            'academicBroadsheets'   => collect( $broadsheets ),
            'broadsheetStatus'      => (string) $academicBroadsheet->status,
            'classArm'              => $this->classArm,
        ]);
    }

    public function approval(string $classArmId, string $classSubjectId, Request $request)
    {
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $this->classArm = $teacher->classArm()->where('uuid', $classArmId)->first();

        if( ! $this->classArm ){
            abort(404);
        }

        $classSubject = ClassSubject::whereUuid($classSubjectId);

        if( ! $classSubject || ! $classSubject->academicBroadsheet ){
            return back();
        }

        $academicBroadsheet = AcademicBroadSheet::query()
            ->where('class_arm', $classArmId)
            ->where('class_subject_id', $classSubjectId)->first();//$classSubject->academicBroadsheet->where('class_arm', $classArmId)->first();

        ! $academicBroadsheet ? abort(404) : null;

        if( $request->has(AcademicBroadSheet::NOT_APPROVED_STATUS) ){

            Session::flash('successFlash', 'Broadsheet disapproved successfully!!!');

            $academicBroadsheet->setStatus(AcademicBroadSheet::NOT_APPROVED_STATUS);

        }

        if ( $request->has(AcademicBroadSheet::APPROVED_STATUS) ){

            Session::flash('successFlash', 'Broadsheet approved successfully!!!');

            $academicBroadsheet->setStatus(AcademicBroadSheet::APPROVED_STATUS);

        }

        return back();
    }

}
