<?php

namespace App\Http\Livewire\Tenant\Teacher;

use App\Actions\Tenant\SchoolClass\ClassTeacher\CreateNewClassTeacherAction;
use App\Actions\Tenant\Teacher\CreateNewTeacherAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use function Livewire\str;

class AddTeacher extends Component
{
    public string $fullName = '';
    public string $email = '';
    public string $staffId = '';
    public string $address = '';

    public string $schoolClassId = '';
    public string $classSectionId = '';
    public string $sectionCategoryId = '';

    public $classSections = [];
    public bool $isClassSectionEnabled = false;
    public string $classSectionName = '-- choose a section --';

    public $sectionCategories = [];
    public bool $isSectionCategoryVisible = false;
    public string $sectionCategoryLabel = '-- choose a category --';

    public $subjectHolders  = [];
    public $selectedSubject = [];

    public array $designation = [];

    protected $teacherId = '';

    protected $rules = [
        'fullName' => ['required'],
        'email' => ['required'],
    ];

    public function render()
    {
        return view('livewire.tenant.teacher.add-teacher', [
            'schoolClass'   => SchoolClass::query()->get(['uuid', 'class_name']),
            'subjects'      => Subject::query()->get(['uuid', 'subject_name']),
        ]);
    }

    public function store()
    {
        $this->validate();

        $user = (new CreateUserAction())->execute([
            'name'      => $this->fullName,
            'email'     => $this->email,
            'password'  => Hash::make(random_number(1,9,5)),
        ]);

        //@todo assign role

        $teacher =  (new CreateNewTeacherAction())->execute($user, [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'staff_id' => $this->staffId,
            'address' => $this->address,
        ]);

        $this->teacherId = (string) $teacher->uuid;

        if( collect($this->designation)->contains('class-teacher') == 'class-teacher' ){
            (new CreateNewClassTeacherAction())->execute([
                'teacher_id' => (string) $teacher->uuid,
                'school_class_id' => $this->schoolClassId,
                'class_section_id' => $this->classSectionId,
                'class_section_category_id' => $this->sectionCategoryId,
            ]);
        }

        if (collect($this->designation)->contains('subject-teacher') == 'subject-teacher' ){

            foreach ($this->selectedSubject as $classSubject){
                $this->attachSubjectTeacher($classSubject['classSubject']);
            }

        }


        $this->redirectRoute('createTeacher');
    }

    private function attachSubjectTeacher($classSubjectId)
    {
        $classSubject = ClassSubject::query()->where('uuid', $classSubjectId)->first();

        $classSubject->teacher_id = $this->teacherId;

        $classSubject->save();
    }

    public function setDesignation($value, $checked)
    {
        if ( $checked ){
            $this->designation [] = $value;
            return;
        }

        $index = collect($this->designation)->search($value);

        array_splice($this->designation, $index, 1);

    }

    public function getClassSection(string $uuid)
    {
        $this->schoolClassId = $uuid;

        $this->classSections = [];

        $this->classSections = SchoolClass::query()->where('uuid', $uuid)->first()->classSection;

        $this->isClassSectionEnabled = true;

        $this->sectionCategories = [];

        return $this->isSectionCategoryVisible = false;
    }

    public function getSectionCategory(string $uuid, string $classSectionName)
    {
        $this->classSectionId = $uuid;

        $this->classSectionName = $classSectionName;

        $classSection = ClassSection::query()->where('uuid', $uuid)->first();

        if( $classSection && ! $classSection->classSectionCategory->isEmpty() ){

            $this->sectionCategories = $classSection->classSectionCategory;

           return $this->isSectionCategoryVisible = true;
        }

        $this->sectionCategories = [];

        return $this->isSectionCategoryVisible = false;
    }

    public function selectSectionCategory(string $sectionCategoryId,string $sectionCategory)
    {
        $this->sectionCategoryId = $sectionCategoryId;

        $this->sectionCategoryLabel = $sectionCategory;
    }

    public function addSubjectHolder()
    {
        $this->subjectHolders [] = [];
    }

    public function removeSubjectHolder($index)
    {
        array_splice($this->selectedSubject, $index, 1);

        array_splice($this->subjectHolders, $index, 1);
    }

    public function selectSubject(Subject $subject, $index)
    {
        $classSubject = $subject->classSubject->whereNull('teacher_id');
        $classSubject->load(['schoolClass']);

        $this->selectedSubject [$index]= [
            'subjectName'   => $subject->subject_name,
            'schoolClasses' => ($classSubject),
            'className'     => 'choose a class',
            'classSection'  => '---',
        ];
    }

    public function selectSchoolClass(ClassSubject $classSubject, $index)
    {
        $this->selectedSubject [$index] ['className'] = $classSubject->schoolClass->class_name;

        if( $classSubject->classSection && $classSubject->classSectionCategory ){
            $classSections = "{$classSubject->classSectionType->section_name} - {$classSubject->classSectionCategoryType->category_name}";
        }
        elseif ( $classSubject->classSection && ! $classSubject->classSectionCategory ){
            $classSections = $classSubject->classSectionType->section_name;
        }
        else{
            $classSections = 'All Section';
        }

        $this->selectedSubject [$index] ['classSection'] = $classSections;

        $this->selectedSubject [$index] ['classSubject'] = $classSubject->uuid;

    }

}
