<?php


namespace App\Actions\Tenant\AcademicSession;


use App\Actions\Tenant\ClassArm\CreateNewClassArmAction;
use App\Actions\Tenant\Fee\CreateNewSchoolFeeAction;
use App\Actions\Tenant\SchoolClass\ClassSubject\CreateNewClassSubjectAction;
use App\Actions\Tenant\Student\AttachSubjectsToStudents;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Student;
use Illuminate\Database\Eloquent\Model;

class ProcessNewSessionAction
{
    private Model $academicSession;
    private $currentAcademicSession;

    public function __construct(Model $academicSession)
    {
        $this->academicSession = $academicSession;

        $this->currentAcademicSession = AcademicSession::whereUuid(Setting::getCurrentAcademicSessionId());
    }

    public function execute()
    {
        //@todo retain classArm students, class teacher with new session
        $this->retainClassArm();

        //@todo school class fees
        $this->retainSchoolFee();

    }

    private function retainSchoolFee()
    {
        SchoolFee::all()->map(function ($schoolFee){
            $feeItems = $schoolFee->feesItems()->get(['name','amount','description'])->toArray();
            $input = [
                'term_id' => $schoolFee->term_id,
                'name' => $schoolFee->name,
                'amount' => $schoolFee->amount,
            ];

            $schoolClasses = collect(SchoolClass::query()->where('school_fees_id', $schoolFee->uuid)->get('uuid')->first())->toArray();

            (new CreateNewSchoolFeeAction)->execute($input, $feeItems, $schoolClasses, $this->academicSession->uuid) ;

        });
    }

    private function retainClassArm()
    {
        $classArms = ClassArm::all();

        foreach ($classArms as $classArm){

            if ( $classArm->schoolClass->level < 6 && $classArm->schoolClass->level != 3 ){

                $nextLevel = $classArm->schoolClass->level + 1;

                $nextClass = SchoolClass::query()->where('level', $nextLevel)->first();

                if(! $nextClass ){
                    continue;
                }

                $newClassArm = (new CreateNewClassArmAction)->execute([
                    'school_class_id' => $nextClass->uuid,
                    'class_section_id' => $classArm->class_section_id,
                    'class_section_category_id' => $classArm->class_section_category_id,
                    'class_teacher' => $classArm->class_teacher ?? null,
                    'students' => $classArm->students,
                    'academic_session_id' => $this->academicSession->uuid,
                ]);

                //retain class subject with class teacher
                $this->retainClassSubject($classArm, $nextClass);

                //update student class -- promoting student
                $classArm->getStudents()->map(function ($student) use($newClassArm, $classArm){
                    $student->update([
                        'class_arm' => $newClassArm->uuid,
                    ]);
                    //retain student subjects
                    $this->retainStudentSubject($student, $classArm);
                });
            }
        }
    }

    private function retainClassSubject(Model $classArm, Model $nextClass)
    {
        collect($classArm->classSubject)->map(function ($classSubject) use($nextClass){
            $classArms = ClassArm::query()
                ->withoutGlobalScope('academicSession')
                ->where('school_class_id', $nextClass->uuid)
                ->where('academic_session_id', $this->academicSession->uuid)
                ->pluck('uuid');

            (new CreateNewClassSubjectAction)->execute([
                'subject_id' => $classSubject->subject_id,
                'class_arm' => $classSubject->class_arm == null ? null : ($classArms->isEmpty() ? null : $classArms),
                'school_class_id' => $nextClass->school_class_id,
                'class_section_id' => $classSubject->class_section_id ?? null,
                'class_section_category_id' => $classSubject->class_section_category_id ?? null,
                'academic_session_id' => $this->academicSession->uuid,
                'teacher_id' => $classSubject->teacher_id ?? null,
            ]);
        });
    }

    private function retainStudentSubject(Student $student, Model $classArm)
    {
        $classSubjectIds = $classArm->getClassSubjects(false, $this->academicSession->uuid)->map(function ($classSubject){
            return $classSubject->uuid;
        })->toArray();

        (new AttachSubjectsToStudents($student))->execute($classSubjectIds, $this->academicSession->uuid);
    }
}
