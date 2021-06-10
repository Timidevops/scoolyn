<?php

namespace App\Http\Livewire\Tenant\Classes;

use App\Actions\Tenant\SchoolClass\ClassTeacher\CreateNewClassTeacherAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\Teacher;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class AddTeacher extends Component
{
    public Model $schoolClass;

    public bool $isAddTeacherModalOpen = false;

    public string $classSectionLabel = '-- choose a section --';
    public bool $classSectionDropdown = false;

    public $classSectionCategories = [];
    public string $classSectionCategoryLabel = '-- choose a category --';
    public bool $isClassSectionCategory = false;
    public bool $classSectionCategoryDropdown = false;

    public string $teacherLabel = '-- choose a category --';
    public bool $teacherDropdown = false;

    public string $classSectionId = '';
    public string $classSectionCategoryId = '';
    public string $teacherId = '';

    public function render()
    {
        return view('livewire.tenant.classes.add-teacher', [
            'classSections' => $this->schoolClass->classSection,
            'teachers' => Teacher::query()->get(['uuid', 'full_name']),
        ]);
    }

    public function mount($schoolClass)
    {
        $this->schoolClass = $schoolClass;
    }

    public function store()
    {
        if( ! $this->classSectionId || ! $this->teacherId ){
            return false;
        }

        //@todo filter duplicate

        (new CreateNewClassTeacherAction())->execute([
            'teacher_id' => $this->teacherId,
            'school_class_id' => $this->schoolClass->uuid,
            'class_section_id' => $this->classSectionId,
            'class_section_category_id' => $this->classSectionCategoryId,
        ]);

        return redirect()->route('classTeacher',$this->schoolClass->slug);
    }

    public function selectClassSection(string $classSectionId, string $classSectionName)
    {
        $this->classSectionId = $classSectionId;

        $this->classSectionLabel = $classSectionName;

        $this->classSectionDropdown = false;

        $this->getClassSectionCategory();
    }

    public function selectClassSectionCategory(string $classSectionCategoryId, string $classSectionCategoryName)
    {
        $this->classSectionCategoryId = $classSectionCategoryId;

        $this->classSectionCategoryLabel = $classSectionCategoryName;

        $this->classSectionCategoryDropdown  = false;
    }

    public function selectTeacher(string $teacherId, string $teacherName)
    {
        $this->teacherId = $teacherId;

        $this->teacherLabel = $teacherName;

        $this->teacherDropdown = false;
    }

    private function getClassSectionCategory(): void
    {
        $classSection = ClassSection::query()->where('uuid', $this->classSectionId)->first();

        if( $classSection && ! $classSection->classSectionCategory->isEmpty() ){

            $this->classSectionCategories = $classSection->classSectionCategory;

            $this->isClassSectionCategory = true;
            return;
        }

        $this->classSectionCategories = [];

        $this->isClassSectionCategory = false;
    }
}
