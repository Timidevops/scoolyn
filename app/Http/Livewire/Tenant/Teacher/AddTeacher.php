<?php

namespace App\Http\Livewire\Tenant\Teacher;

use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Teacher\CreateNewTeacherAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Actions\Tenant\User\WelcomeNewUserAction;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSubject;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\SchoolSubject;
use App\Models\Tenant\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddTeacher extends Component
{
    public string $fullName = '';
    public string $email = '';
    public string $staffId = '';
    public string $address = '';
    public string $phone = '';

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
        'email' => ['nullable','required_without:phone','sometimes','unique:tenant.users,email'],
        'phone' => ['nullable','required_without:email','sometimes','unique:tenant.users,phone'],
    ];

    public function render()
    {
        $classArms = ClassArm::query()->whereNull('class_teacher')->get();

        $classArms = $classArms->map(function ($classArm){
            $uuid [] = $classArm->schoolClass->uuid;
            return $uuid;
        });

        $classSubjects = ClassSubject::query()->whereNull('teacher_id')->get();

        $classSubjects = $classSubjects->map(function ($classSubject){
            if($classSubject->subject()->exists()){
                $uuid [] = $classSubject->subject->uuid;
                return $uuid;
            }
        });

        return view('livewire.tenant.teacher.add-teacher', [
            'schoolClass'   => SchoolClass::query()->whereIn('uuid', $classArms)->get(['uuid', 'class_name']),
            'subjects'      => SchoolSubject::query()->whereIn('uuid', $classSubjects)->get(['uuid', 'subject_name']),
        ]);
    }

    public function store()
    {
        $this->validate();

        $password = strtolower(str_replace(' ', '', $this->fullName));
        if($this->phone != ''){
            $password = $this->phone;
        }
        $password = Hash::make($password);
        $user = (new CreateUserAction())->execute([
            'name' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'password'  => $password,
        ]);

        $teacher =  (new CreateNewTeacherAction())->execute($user, [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'staff_id' => $this->staffId,
            'address' => $this->address,
        ]);

        $this->teacherId = (string) $teacher->uuid;

        if( collect($this->designation)->contains('class-teacher') == 'class-teacher' ){

            if($this->classSectionId == ''){
                return;
            }

            if( $this->classSectionId == 'all' ){

                $classArms = ClassArm::query()->where('school_class_id', $this->schoolClassId)->get();

                foreach ($classArms as $classArm){
                    $this->attachClassTeacher($classArm);
                }

            }
            elseif ($this->sectionCategoryId == 'all'){

                $classArms = ClassArm::query()
                    ->where('school_class_id', $this->schoolClassId)
                    ->where('class_section_id', $this->classSectionId)->get();

                foreach ($classArms as $classArm){
                    $this->attachClassTeacher($classArm);
                }
            }
            else{

                $classArm = ClassArm::query()
                    ->where('school_class_id', $this->schoolClassId)
                    ->where('class_section_id', $this->classSectionId)
                    ->where('class_section_category_id', $this->sectionCategoryId)->first();

                if( ! $classArm){
                    return;
                }

                $classArm->class_teacher = (string) $teacher->uuid;

                $classArm->save();

            }

            $user->assignRole(User::CLASS_TEACHER_USER);
        }

        if (collect($this->designation)->contains('subject-teacher') == 'subject-teacher' ){

            if(collect($this->selectedSubject)->isEmpty()){
                return;
            }

            foreach ($this->selectedSubject as $classSubject){
                if( ! $classSubject['classSubject'] ){
                    return;
                }

                $this->attachSubjectTeacher($classSubject['classSubject']);
            }

            $user->assignRole(User::SUBJECT_TEACHER_USER);
        }

        //@todo welcome email notification
        (new WelcomeNewUserAction)->execute($user);

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::ADD_TEACHER
        ]);

        Session::flash('successFlash', 'Teacher added successfully!!!');

        $this->redirectRoute('createTeacher');
    }

    private function attachClassTeacher($classArm)
    {
        $classArm->class_teacher = $this->teacherId;

        $classArm->save();
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

        $this->classSections = SchoolClass::query()->where('uuid', $uuid)->first()->classArm->unique('class_section_id');

        $this->isClassSectionEnabled = true;

        $this->sectionCategories = [];

        return $this->isSectionCategoryVisible = false;
    }

    /**
     * @param string $uuid
     * @param string $classArmId
     * @param string $classSectionName
     * @return bool|void
     */
    public function getSectionCategory(string $uuid, string $classArmId = '', string $classSectionName = '')
    {
        if($uuid == 'all'){
            $this->classSectionName = 'All Sections';
            $this->classSectionId  = $uuid;
            return;
        }

        $this->classSectionId = $uuid;

        $this->classSectionName = $classSectionName;

        $classSection = ClassArm::query()->where('uuid', $classArmId)->first();

        if( $classSection && $classSection->classSectionCategory ){

            $this->sectionCategories = $classSection->classSectionCategory->get();

           return $this->isSectionCategoryVisible = true;
        }

        $this->sectionCategories = [];

        return $this->isSectionCategoryVisible = false;
    }

    public function selectSectionCategory(string $sectionCategoryId, string $sectionCategory)
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

    public function selectSubject(SchoolSubject $subject, $index)
    {
        $classSubject = $subject->classSubject->whereNull('teacher_id');
        $classSubject->load(['schoolClass']);

        $this->selectedSubject [$index]= [
            'subjectName'   => $subject->subject_name,
            'schoolClasses' => ($classSubject),
            'className'     => 'choose a class',
            'classSection'  => '---',
            'classSubject'  => [],
        ];
    }

    public function selectSchoolClass(ClassSubject $classSubject, $index)
    {
        $this->selectedSubject [$index] ['className'] = $classSubject->schoolClass->class_name;

        if( $classSubject->classSection && $classSubject->classSectionCategory ){
            $classSections = "{$classSubject->classSectionType->section_name} - {$classSubject->classSectionCategoryType->category_name}";
        }
        elseif ( $classSubject->classSection && ! $classSubject->classSectionCategory ){
            $classSections = $classSubject->classSection->section_name;
        }
        else{
            $classSections = 'All Section';
        }

        $this->selectedSubject [$index] ['classSection'] = $classSections;

        $this->selectedSubject [$index] ['classSubject'] = $classSubject->uuid;

    }

}
