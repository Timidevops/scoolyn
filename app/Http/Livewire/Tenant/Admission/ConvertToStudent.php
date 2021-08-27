<?php

namespace App\Http\Livewire\Tenant\Admission;

use App\Actions\Tenant\Admission\ConvertToStudentAction;
use App\Models\Tenant\AdmissionApplicant;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\SchoolClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ConvertToStudent extends Component
{
    public string $applicant;

    public bool $addClassModal = false;

    public string $schoolClassId = '';
    public string $classSectionId = '';
    public string $classSectionCategoryId = '';

    public bool $schoolClassDropdown = false;
    public string $schoolClassLabel = '-- choose a class --';

    public bool $classSectionDropdown = false;
    public string $classSectionLabel = '-- choose a class section --';
    public $classSections = [];

    public bool $isClassSectionCategory = false;
    public bool $classSectionCategoryDropdown = false;
    public string $classSectionCategoryLabel = '-- choose a class section category --';
    public $classSectionCategories = [];

    public bool $errorDiv = false;
    public string $errorMessage = '';

    public function mount(string $applicant)
    {
        $this->applicant = $applicant;
    }

    public function render()
    {
        return view('livewire.tenant.admission.convert-to-student', [
            'schoolClasses' => SchoolClass::query()->get(['uuid', 'class_name']),
        ]);
    }

    public function store()
    {
        if( ! $this->getClassArm() ){
            $this->errorDiv = true;
            $this->errorMessage = 'Kindly select correct class arm';
            return;
        }

        (new ConvertToStudentAction)->execute([
            'applicantId' => $this->applicant,
            'classArmId' => $this->getClassArm()->uuid,
        ]);

        Session::flash('successFlash', 'Applicant added to class a student successfully!!!');

        $this->redirectRoute('singleApplicant', $this->applicant);
    }

    /**
     * @return Model | null
     */
    public function getClassArm()
    {
        return ClassArm::query()
            ->where('school_class_id', $this->schoolClassId)
            ->where('class_section_id', $this->classSectionId)
            ->where('class_section_category_id', $this->classSectionCategoryId)->first();
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
}
