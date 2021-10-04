<?php

namespace App\Http\Livewire\Tenant\Classes;

use App\Actions\Tenant\ClassArm\CreateNewClassArmAction;
use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\SchoolClass\ClassTeacher\CreateNewClassSectionCategoryTypeAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionCategoryAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionTypeAction;
use App\Actions\Tenant\SchoolClass\CreateNewSchoolClassAction;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassSectionCategoryType;
use App\Models\Tenant\ClassSectionType;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Setting;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddClassSection extends Component
{
    public string $schoolClass = '', $defaultClass = '';
    public string $classSection = '', $newClassSection = '';
    public string $classSectionCategory = '', $newClassSectionCategory = '';

    public bool $errorDiv = false;
    public string $errorMessage = '';

    public bool $addClassModal = false;

    public string $classLabel = '-- choose a class --';
    public bool $classDropdown = false;
    public bool $classDropdownOption = false;
    public bool $defaultClassOptionDropdown = false;
    public array $defaultClassOptions = [];

    public string $sectionLabel = '-- choose a section --';
    public bool $sectionDropdown = false;
    public bool $sectionDropdownOption = false;
    public bool $addNewSection = false;

    public string $sectionCategoryLabel = '-- choose a section category --';
    public bool $sectionCategoryDropdown = false;
    public bool $sectionCategoryDropdownOption = false;
    public bool $addNewSectionCategory = false;

    protected array $rules = [
        'newClassSection' => ['nullable', 'unique:tenant.class_section_types,section_name'],
        'newClassSectionCategory' => ['nullable', 'unique:tenant.class_section_category_types,category_name'],
    ];

    public function render()
    {
        return view('livewire.tenant.classes.add-class-section', [
            'schoolClasses'            => SchoolClass::query()->get(['uuid', 'class_name']),
            'classSectionTypes'         => ClassSectionType::query()->get(['section_name', 'uuid']),
            'classSectionCategoryTypes' => ClassSectionCategoryType::query()->get(['category_name', 'uuid']),
        ]);
    }

    public function store()
    {
        $this->validate();

        $schoolClassId              = $this->schoolClass() ? $this->schoolClass()->uuid : $this->schoolClass;
        $classSectionTypeId         = $this->classSection();
        $classSectionCategoryTypeId = $this->classSectionCategory();

        $isClassArmExist = ClassArm::query()
            ->where('school_class_id', $schoolClassId)
            ->where('class_section_id', $classSectionTypeId)
            ->where('class_section_category_id', $classSectionCategoryTypeId)->exists();

        if( $isClassArmExist ){
            $this->errorDiv = true;
            $this->errorMessage = 'Class Arm already exist';

            return false;
        }

        if( ! $schoolClassId || ! $classSectionTypeId){
            $this->errorDiv = true;
            $this->errorMessage = 'Kindly select a class, section or section category';

            return false;
        }

        //create new class section
        (new CreateNewClassArmAction())->execute([
            'school_class_id' => $schoolClassId,
            'class_section_id' => $classSectionTypeId,
            'class_section_category_id' => $classSectionCategoryTypeId,
            'academic_session_id' => Setting::getCurrentAcademicSessionId(),
        ]);

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::ADD_SCHOOL_CLASSES
        ]);

        $this->addClassModal = false;

        Session::flash('successFlash', 'Class added successfully!!!');

        return redirect()->route('listClass');
    }

    private function schoolClass()
    {
        $schoolClass = SchoolClass::query()
            ->where('class_name', $this->classLabel)
            ->orWhere('uuid', $this->schoolClass)
            ->first();

        if( ! $schoolClass && $this->defaultClass ){
            $schoolClass = (new CreateNewSchoolClassAction())->execute([
                'class_name' => $this->defaultClass,
            ]);
        }

        return $schoolClass;
    }

    private function classSection()
    {
        $classSectionType = $this->classSection;

        if( ! $classSectionType && $this->newClassSection ){
            $classSectionType = (new CreateNewClassSectionTypeAction())->execute([
                'section_name' => $this->newClassSection, //?? 'default_class',
            ]);

            $classSectionType = $classSectionType->uuid;
        }

        return $classSectionType;
    }

    private function classSectionCategory()
    {
        $classSectionCategoryType = $this->classSectionCategory;

        if( ! $classSectionCategoryType && $this->newClassSectionCategory ){
            $classSectionCategoryType = (new CreateNewClassSectionCategoryTypeAction())->execute([
                'category_name' => $this->newClassSectionCategory,
            ]);

            $classSectionCategoryType = $classSectionCategoryType->uuid;
        }

        return $classSectionCategoryType;
    }

    public function toggleClassDropdown($dropdown, $dropdownOption='')
    {
        $this->classDropdown = $dropdown == 1;

        $this->classDropdownOption = $dropdownOption == 1;

        //$this->defaultClassOptionDropdown = false;
    }

    public function toggleDefaultClassDropdown($dropdown)
    {
        $this->toggleClassDropdown( true, ! $this->classDropdownOption);

        $this->defaultClassOptionDropdown = $dropdown == 1;
    }

    public function selectClass($classId, $className)
    {
        $this->defaultClass        = '';
        $this->schoolClass         = $classId;
        $this->classLabel          = $className;
        $this->classDropdown       = false;
        $this->classDropdownOption = false;
    }

    public function selectDefaultClass($class)
    {
        $this->schoolClass                = '';
        $this->defaultClass               = $class;
        $this->classLabel                 = $class;
        $this->classDropdown              = false;
        $this->defaultClassOptionDropdown = false;
    }

    public function toggleClassSection($section, $sectionOption)
    {
        $this->sectionDropdown = $section == 1;
        $this->sectionDropdownOption = $sectionOption == 1;
        $this->newClassSection = '';
    }

    public function toggleAddNewSection($section)
    {
        $this->toggleClassSection(true, ! $this->sectionDropdownOption);
        $this->addNewSection = $section == 1;
        $this->newClassSection = '';
    }

    public function selectClassSection($sectionId, $sectionName)
    {
        $this->classSection          = $sectionId;
        $this->sectionLabel          = $sectionName;
        $this->sectionDropdown       = false;
        $this->sectionDropdownOption = false;
    }

    public function toggleClassSectionCategory($section, $sectionOption)
    {
        $this->sectionCategoryDropdown = $section == 1;
        $this->sectionCategoryDropdownOption = $sectionOption == 1;
        $this->newClassSectionCategory = '';
    }

    public function toggleAddNewSectionCategory($section)
    {
        $this->toggleClassSectionCategory(true, ! $this->sectionCategoryDropdownOption);
        $this->addNewSectionCategory = $section == 1;
        $this->newClassSectionCategory = '';
    }

    public function selectClassSectionCategory($sectionCategoryId, $sectionCategoryName)
    {
        $this->classSectionCategory          = $sectionCategoryId;
        $this->sectionCategoryLabel          = $sectionCategoryName;
        $this->sectionCategoryDropdown       = false;
        $this->sectionCategoryDropdownOption = false;
    }

}
