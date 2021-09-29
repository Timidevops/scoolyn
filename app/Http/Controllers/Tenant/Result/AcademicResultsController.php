<?php

namespace App\Http\Controllers\Tenant\Result;

use App\Actions\Tenant\Result\Broadsheet\Helper\GetClassSubjectBroadsheetAction;
use App\Actions\Tenant\Result\Helpers\GetAcademicBroadsheet;
use App\Http\Controllers\Controller;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\AcademicGradingFormat;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\ContinuousAssessmentStructure;
use App\Models\Tenant\ReportCardBreakdownFormat;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Student;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AcademicResultsController extends Controller
{
    private $classArm;
    private $subjectBroadsheet;
    private array $student = [
        'previousReportCard' => null,
    ];

    public function index()
    {
        $classArm = ClassArm::all();

        if ( Auth::user()->hasRole(User::SUPER_ADMIN_USER) && $classArm->isEmpty() ){

            Session::flash('warningFlash', 'Kindly add class arm');

            return redirect()->route('listClass');
        }

        if ( $classArm->isEmpty() ){
            abort(404);
        }

        $classArm->load(['schoolClass', 'classSection', 'classSectionCategory']);

        return view('tenant.pages.result.academicResult.index', [
           'totalClass'    => count($classArm),
            'classArm'     => $classArm,
        ]);

    }

    public function single(string $classArmId)
    {
        $classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        $classSubject = $classArm->classSubject->filter(function ($classSubject) use($classArm){

            if($classSubject->class_arm){

                return $classSubject->whereJsonContains('class_arm', $classArm->uuid);
            }
            elseif ($classSubject->class_section_id && ! $classSubject->class_section_category_id){
                return  $classSubject->class_section_id == $classArm->class_section_id;
            }

            return $classSubject->class_section_id == $classArm->class_section_id && $classSubject->class_section_category_id == $classArm->class_section_category_id;
        });

        return view('tenant.pages.result.academicResult.single', [
            'classArm' => $classArm,
            'classSubjects' => $classSubject,
        ]);
    }

    public function singleSubject(string $classArmId, string $classSubjectId)
    {
        $this->classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        $classSubject = ClassSubject::whereUuid($classSubjectId)->withoutGlobalScope('teacher')->first();

        if ( $classSubject->academicBroadsheet ){
            $classSubjectBroadsheet = (new GetClassSubjectBroadsheetAction)->execute($this->classArm, $classSubject);

            array_splice($classSubjectBroadsheet, ReportCardBreakdownFormat::currentFormatPlacementId(),1);

            $this->student['previousReportCard'] = $classSubjectBroadsheet;
        }

        $academicBroadsheet = AcademicBroadSheet::query()
            ->where('class_arm', $classArmId)
            ->where('class_subject_id', $classSubjectId)
            ->where('report_card', Setting::getCurrentCardBreakdownFormat())
            ->first();


        ! $academicBroadsheet ? abort(404) : null;

        if( ! $academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS || !  $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){
            abort(404);
        }

        if( $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){
            return $this->edit($classSubject, $academicBroadsheet);
        }

        // get grade format for class
        $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $this->classArm->school_class_id)->first();

        if( ! $gradeFormats ){
            Session::flash('warningFlash', 'Error processing request, contact school admin.');

            return back();
        }

        $gradeFormats = collect($gradeFormats->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        $this->subjectBroadsheet = collect( $academicBroadsheet->meta['academicBroadsheet'] );

        return view('tenant.pages.result.academicResult.singleSubject', [
            'caAssessmentStructureFormat' => collect( $academicBroadsheet->meta['caFormat'] ),
            'gradeFormats'          => collect($gradeFormats['gradingFormat']),
            'classSubject'          => $classSubject,
            'classSubjectId'        => $classSubject->uuid,
            'academicBroadsheets'   => collect( $this->getStudentBroadsheets() ),
            'broadsheetStatus'      => (string) $academicBroadsheet->status,
            'classArm'              => ($this->classArm instanceof ClassArm) ? $this->classArm->uuid : $this->classArm,
            'student'               => $this->student,
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

        $reportFormat =collect($caFormat->meta)->where('nameOfReport', Setting::getCurrentCardBreakdownFormat())->first();

        return view('tenant.pages.result.academicResult.singleSubject', [
            'caAssessmentStructure' => collect( $reportFormat ),
            'classSubject'          => $classSubject,
            'classSubjectId'        => $classSubject->uuid,
            'academicBroadsheets'   => collect( $broadsheets ),
            'broadsheetStatus'      => (string) $academicBroadsheet->status,
            'classArm'              => ($this->classArm instanceof ClassArm) ? $this->classArm->uuid : $this->classArm,
            'student'               => $this->student,
        ]);
    }

    public function approval(string $classArmId, string $classSubjectId, Request $request)
    {
        $this->classArm = ClassArm::whereUuid($classArmId)->firstOrFail();

        if( ! $this->classArm ){
            abort(404);
        }

        $classSubject = ClassSubject::whereUuid($classSubjectId)->withoutGlobalScope('teacher')->first();

        if( ! $classSubject || ! $classSubject->academicBroadsheet ){
            return back();
        }

        $academicBroadsheet = AcademicBroadSheet::query()
            ->where('class_arm', $classArmId)
            ->where('class_subject_id', $classSubjectId)
            ->where('report_card', Setting::getCurrentCardBreakdownFormat())
            ->first();

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
