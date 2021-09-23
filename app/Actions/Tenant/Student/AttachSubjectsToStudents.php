<?php


    namespace App\Actions\Tenant\Student;


    use App\Actions\Tenant\Student\StudentSubject\CreateNewStudentSubjectAction;
    use App\Models\Tenant\Setting;
    use App\Models\Tenant\Student;
    use Illuminate\Support\Facades\Session;

    class AttachSubjectsToStudents
    {
        public Student $student;

        public function __construct(Student $student)
        {
            $this->student = $student;
        }

        public function execute(array $subjectIds = null, string $newSessionId = '') : bool
        {
            if( $newSessionId ){
                (new CreateNewStudentSubjectAction())->execute($this->student, [
                    'subjects' => $subjectIds,
                    'academic_session_id' => $newSessionId,
                ]);
            }

            if( $this->student->subjects()->doesntExist() ){

                if(empty($subjectIds)){
                    $subjectIds = $this->fetchClassSubjects();
                }

                (new CreateNewStudentSubjectAction())->execute($this->student, [
                    'subjects' => $subjectIds,
                    'academic_session_id' => Setting::getCurrentAcademicSessionId(),
                ]);

                return true;
            }

            if(empty($subjectIds)){
                $subjectIds = $this->fetchClassSubjects();
            }

            $this->student->subjects->subjects = collect($this->student->subjects->subjects)->merge($subjectIds);

            $this->student->subjects->save();

            return true;
        }

        private function fetchClassSubjects() : array
        {
            return $this->student->classArm->getClassSubjects()->map(function ($classSubject){
                return $classSubject->uuid;
            });
        }
    }
