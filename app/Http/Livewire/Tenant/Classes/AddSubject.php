<?php

namespace App\Http\Livewire\Tenant\Classes;

use App\Actions\Tenant\SchoolClass\ClassSubject\CreateNewClassSubjectAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\Subject;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class AddSubject extends Component
{
    public Model $schoolClass;

    public string $classSectionLabel = '-- choose a section --';

    public $classSectionCategories = [];
    public string $classSectionCategoryLabel = '-- choose a category --';

    public bool $isOpenAddSubjectModal = false;
    public bool $classSectionDropdown = false;

    public bool $isClassSectionCategory = false;
    public bool $classSectionCategoryDropdown = false;

    public string $subjectLabel = '-- choose a subject --';
    public bool $subjectDropdown = false;

    public string $classSectionId = '';
    public string $classSectionCategoryId = '';
    public string $subjectId = '';

    public function render()
    {
        return view('livewire.tenant.classes.add-subject', [
            'classSections' => $this->schoolClass->classSection,
            'subjects'      => Subject::query()->get(['uuid', 'subject_name']),
        ]);
    }

    public function mount($schoolClass)
    {
        $this->schoolClass = $schoolClass;
    }

    public function store()
    {
        if( ! $this->classSectionId || ! $this->subjectId){
            return false;
        }

        //@todo filter duplicate

        (new CreateNewClassSubjectAction())->execute([
            'subject_id'                => $this->subjectId,
            'school_class_id'           => $this->schoolClass->uuid,
            'class_section_id'          => $this->classSectionId == 'all' ? null : $this->classSectionId ?? null,
            'class_section_category_id' => $this->classSectionCategoryId == 'all' ? null : $this->classSectionCategoryId ?? null,
        ]);

        return redirect()->route('listClassSubject',$this->schoolClass->slug);
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

    public function selectSubject(string $subjectId, string $subjectName)
    {
        $this->subjectId = $subjectId;

        $this->subjectLabel = $subjectName;

        $this->subjectDropdown = false;
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
