<?php

namespace App\Http\Livewire\Tenant\Teacher;

use App\Actions\Tenant\SchoolClass\ClassTeacher\CreateNewClassTeacherAction;
use App\Actions\Tenant\Teacher\CreateNewTeacherAction;
use App\Actions\Tenant\User\CreateUserAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Subject;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

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

        (new CreateNewClassTeacherAction())->execute([
            'teacher_id' => (string) $teacher->uuid,
            'school_class_id' => $this->schoolClassId,
            'class_section_id' => $this->classSectionId,
            'class_section_category_id' => $this->sectionCategoryId,
        ]);

        $this->redirectRoute('createTeacher');
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
}
