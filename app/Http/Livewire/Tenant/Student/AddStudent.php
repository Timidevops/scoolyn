<?php

namespace App\Http\Livewire\Tenant\Student;

use App\Actions\Tenant\Student\ClassArm\AttachStudentToClassArmAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Http\Controllers\Tenant\Parent\ParentsController;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Parents;
use App\Models\Tenant\SchoolClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddStudent extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $other_name = '';
    public string $gender = '';
    public string $dob = '';
    public string $address = '';
    public string $matriculation_number = '';
    public string $schoolClassId = '';
    public string $classSectionId = '';
    public string $classSectionCategoryId = '';
    public string $parentId = '';

    public bool $genderDropdown = false;
    public string $genderLabel = '-- choose a gender --';

    public bool $schoolClassDropdown = false;
    public string $schoolClassLabel = '-- choose a class --';

    public bool $classSectionDropdown = false;
    public string $classSectionLabel = '-- choose a class section --';
    public $classSections = [];

    public bool $isClassSectionCategory = false;
    public bool $classSectionCategoryDropdown = false;
    public string $classSectionCategoryLabel = '-- choose a class section category --';
    public $classSectionCategories = [];

    public bool $parentDropdown = false;
    public string $parentLabel = '-- choose a parent --';
    public $parents = [];

    // Parent details
    public bool $addParentModal = false;
    public string $parentGenderLabel = '-- choose a gender --';
    public bool $parentGenderDropdown = false;
    public string $parentFirstName = '';
    public string $parentLastName = '';
    public string $parentEmail = '';
    public string $parentPhoneNumber = '';
    public string $parentGender = '';
    public string $parentAddress = '';

    protected $rules = [
        'first_name' => ['required'],
        'last_name' => ['required'],
        'other_name' => ['required'],
        'gender' => ['required'],
        'dob' => ['required'],
        'address' => ['required'],
    ];

    public function render()
    {
        $this->parents = Parents::query()->get(['uuid', 'first_name', 'last_name']);

        return view('livewire.tenant.student.add-student', [
            'schoolClasses' => SchoolClass::query()->get(['uuid', 'class_name']),
        ]);
    }

    public function store()
    {
        $this->validate();

        $parent = Parents::query()->where('uuid', '=', $this->parentId)->first();

        if( ! $parent ){
            return false;
        }

        if( ! $this->getClassArm() ){
            return false;
        }

        $student = (new CreateNewStudentAction)->execute($parent, [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'other_name' => $this->other_name,
            'gender' => $this->gender,
            'matriculation_number' => $this->matriculation_number,
            'dob' => $this->dob,
            'address' => $this->address,
            'class_arm' => $this->getClassArm()->uuid,
        ]);

        (new AttachStudentToClassArmAction())->execute($this->getClassArm(), [
            'studentId' => (string) $student->uuid,
        ]);

        Session::flash('successFlash', 'Student added successfully!!!');

        $this->redirectRoute('createStudent');

        return  true;
    }

    public function getClassArm(): Model
    {
        return ClassArm::query()
            ->where('school_class_id', $this->schoolClassId)
            ->where('class_section_id', $this->classSectionId)
            ->where('class_section_category_id', $this->classSectionCategoryId)->first();
    }

    public function selectGender(string $gender)
    {
        $this->gender = $gender;

        $this->genderLabel = $gender;

        $this->genderDropdown = false;
    }

    public function selectSchoolClass(string $schoolClassId, string $schoolClassName)
    {
        $this->schoolClassId = $schoolClassId;

        $this->schoolClassLabel = $schoolClassName;

        $this->schoolClassDropdown = false;

        $this->classSections = SchoolClass::query()->where('uuid', $schoolClassId)->first()->classArm;

        $this->classSectionLabel = '-- choose a class section --';

        $this->classSectionDropdown = false;

        $this->isClassSectionCategory = false;

        $this->classSectionCategoryDropdown = false;

        $this->classSectionCategoryLabel = '-- choose a class section category --';
    }

    public function selectClassSection(string $classSectionId, string $classArmId, string $classSectionName)
    {
        $this->classSectionId = $classSectionId;

        $this->classSectionLabel = $classSectionName;

        $this->classSectionDropdown = false;

        $this->classSectionCategoryLabel = '-- choose a class section category --';

        $classSection = ClassArm::query()->where('uuid', $classArmId)->first();

        if( $classSection && $classSection->classSectionCategory ){

            $this->classSectionCategories = $classSection->classSectionCategory->get();

            return $this->isClassSectionCategory = true;
        }

        $this->classSectionCategories = [];

        return $this->isClassSectionCategory = false;
    }

    public function selectClassSectionCategory(string $classSectionCategoryId, string $classSectionCategoryName)
    {
        $this->classSectionCategoryId = $classSectionCategoryId;

        $this->classSectionCategoryLabel = $classSectionCategoryName;

        $this->classSectionCategoryDropdown = false;
    }

    public function selectParent(string $parentId, string $parentName)
    {
        $this->parentId = $parentId;

        $this->parentLabel = $parentName;

        $this->parentDropdown = false;
    }

    public function selectParentGender(string $gender)
    {
        $this->parentGender = $gender;

        $this->parentGenderLabel = $gender;

        $this->parentGenderDropdown = false;
    }

    public function storeParent()
    {
        $request = new Request([
            'indirect' => true,
            'firstName' => $this->parentFirstName,
            'lastName' => $this->parentLastName,
            'email' => $this->parentEmail,
            'phoneNumber' => $this->parentPhoneNumber,
            'gender' => $this->parentGender,
            'address' => $this->parentAddress,
        ]);

        $parent = (new ParentsController())->store($request);

        $this->parentLabel = "{$parent->first_name} {$parent->last_name}";

        $this->parentId = $parent->uuid;

        $this->parents = Parents::query()->get(['uuid', 'first_name', 'last_name']);

        $this->parentDropdown = false;

        $this->addParentModal = false;
    }

}
