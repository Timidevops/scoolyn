<?php


namespace App\Actions\Tenant\AcademicSession;


use App\Actions\Tenant\ClassArm\CreateNewClassArmAction;
use App\Actions\Tenant\SchoolClass\ClassSubject\CreateNewClassSubjectAction;
use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Setting;
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
        //$this->retainClassArm();


        //@todo retain student subjects

        //@todo retain class fees

        dd('pass');

    }

    private function retainClassArm()
    {
        $classArms = ClassArm::all();

        foreach ($classArms as $classArm){
            //@todo pending for Jss 3 -> Sss one
            if ( $classArm->schoolClass->level < 6 ){

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
                $classArm->getStudents()->map(function ($student) use($newClassArm){
                    $student->update([
                        'class_arm' => $newClassArm->uuid,
                    ]);
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
                'school_class_id' => $classSubject->school_class_id,
                'class_section_id' => $classSubject->class_section_id ?? null,
                'class_section_category_id' => $classSubject->class_section_category_id ?? null,
                'academic_session_id' => $this->academicSession->uuid,
                'teacher_id' => $classSubject->teacher_id ?? null,
            ]);
        });
    }
}
