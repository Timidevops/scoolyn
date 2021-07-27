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

class AcademicResultsController extends Controller
{
    private Model $classTeacher;
    private $classArm;
    private $subjectBroadsheet;

    public function index()
    {
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $classArm = $teacher->classArm;

        $classArm->load(['schoolClass', 'classSection', 'classSectionCategory']);

        return view('Tenant.pages.result.academicResult.index', [
           //'classTeacher'  => $teacher->classArm,
           //'classSubjects' => $teacher->getClassSubjects(),
           'totalClass'    => count($classArm),
            'classArm'     => $classArm,
        ]);

    }

    public function single(string $classArmId)
    {
        $teacher = Teacher::whereUserId(Auth::user()->uuid);

        $classArm = $teacher->classArm()->where('uuid', $classArmId)->first();

        if( ! $classArm ){
            abort(404);
        }

        $classSubject = $classArm->classSubject->filter(function ($classSubject) use($classArm){

            if($classSubject->class_arm){

                return $classSubject->whereJsonContains('class_arm', $classArm->uuid);
            }
            elseif ($classSubject->class_section_id && ! $classSubject->class_section_category_id){
                return  $classSubject->class_section_id == $classArm->class_section_id;
            }

            return $classSubject->class_section_id == $classArm->class_section_id && $classSubject->class_section_category_id == $classArm->class_section_category_id;
        });

        //dd($classSubject);

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

        //dd($classSubjectId);

        //dd($classSubjectInstance->subject->subject_name);

//        if($classSubjectInstance->class_arm){
//            $classSubject = $classSubjectInstance->whereJsonContains('class_arm', $classArmId)->first();
//        }
//        elseif($classSubjectInstance->class_section_id && ! $classSubjectInstance->class_section_category_id){
//            $classSubject = $classSubjectInstance->where('class_section_id', $this->classArm->class_section_id)->first();
//        }
//        else{
//            $classSubject = [];
//        }

       // dd($classSubject->subject->subject_name);

        $academicBroadsheet = AcademicBroadSheet::query()
            ->where('class_arm', $classArmId)
            ->where('class_subject_id', $classSubjectId)->first();

        //dd($academicBroadsheet);

        //$this->classTeacher = $teacher->classArm->teacher;

       // $classSubject = ( collect($teacher->getClassSubjects())->whereIn('uuid', $classSubjectId) )->first();

//        if( ! $classSubject || ! $classSubject->academicBroadsheet ){
//
//            abort(404);
//        }
//        dd('here');

        //$academicBroadsheet = $classSubject->academicBroadsheet->where('class_arm', $classArmId)->first();

        ! $academicBroadsheet ? abort(404) : null;

        if( ! $academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS || !  $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){
            abort(404);
        }

        //dd($academicBroadsheet->status);
        if( $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){
            //dd($classSubject);
            return $this->edit($classSubject, $academicBroadsheet);
        }

        // get grade format for class
        $gradeFormats = AcademicGradingFormat::query()->whereJsonContains('school_class', $this->classArm->school_class_id)->first();

        $this->subjectBroadsheet = collect( $academicBroadsheet->meta['academicBroadsheet'] );

//        $isClassTeacherPerSection = $teacher->classArm->class_section_id
//            ? $this->classArm->students
//            : $this->subjectBroadsheet->keys();
//
//        $students = Student::query()->whereIn('uuid', $isClassTeacherPerSection)->get(['uuid','first_name','last_name']);
//
//        $broadsheets = $students->map(function ($item)use($subjectBroadsheet){
//
//            $item['studentName'] = "{$item->first_name} {$item->last_name}";
//
//            $item['studentId']   = $item->uuid;
//
//            $item['broadsheet']  = collect($subjectBroadsheet)->get($item->uuid);
//
//            return collect($item)->except(['first_name', 'last_name', 'uuid'])->toArray();
//        });

        //(new GetAcademicBroadsheet())->execute($broadsheets)

        //dd(collect( $academicBroadsheet->meta['caFormat'] ));

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
        //dd('here');
        $generatedFormat = collect($academicBroadsheet->meta)->has('caFormat');

        $broadsheets = (new GetAcademicBroadsheet())->execute($academicBroadsheet->meta, $generatedFormat);

        $caFormat = ContinuousAssessmentStructure::query()->whereJsonContains('school_class', $classSubject->school_class_id)->first() ;

        //dd($classSubject);

        return view('Tenant.pages.result.academicResult.singleSubject', [
            'caAssessmentStructure' => collect( $caFormat->meta ),
            //'gradeFormats'          => collect([]),
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

        //$this->classTeacher = $teacher->classArm;

        $this->classArm = $teacher->classArm()->where('uuid', $classArmId)->first();

        if( ! $this->classArm ){
            abort(404);
        }

        $classSubject = ClassSubject::whereUuid($classSubjectId);

//        if($classSubjectInstance->class_arm){
//            $classSubject = $classSubjectInstance->whereJsonContains('class_arm', $classArmId)->first();
//        }
//        else{
//            $classSubject = [];
//        }

        //$classSubject = ( collect($teacher->getClassSubjects())->whereIn('uuid', $classSubjectId) )->first();

        if( ! $classSubject || ! $classSubject->academicBroadsheet ){
            return back();
        }

        $academicBroadsheet = AcademicBroadSheet::query()
            ->where('class_arm', $classArmId)
            ->where('class_subject_id', $classSubjectId)->first();//$classSubject->academicBroadsheet->where('class_arm', $classArmId)->first();

        ! $academicBroadsheet ? abort(404) : null;

        if( $request->has(AcademicBroadSheet::NOT_APPROVED_STATUS) ){

            $academicBroadsheet->setStatus(AcademicBroadSheet::NOT_APPROVED_STATUS);

        }

        if ( $request->has(AcademicBroadSheet::APPROVED_STATUS) ){

            $academicBroadsheet->setStatus(AcademicBroadSheet::APPROVED_STATUS);

        }

        return back();
    }

}
