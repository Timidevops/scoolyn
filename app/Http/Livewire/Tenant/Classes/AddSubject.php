<?php

namespace App\Http\Livewire\Tenant\Classes;

use App\Actions\Tenant\SchoolClass\ClassSubject\CreateNewClassSubjectAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\Subject;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class AddSubject extends Component
{
    public $schoolClass;
    public $classArm;
    public $classSubjects;

    public string $classSectionLabel = '-- choose a section --';

    public $classSectionCategories = [];
    public string $classSectionCategoryLabel = '-- choose a category --';

    public bool $isOpenAddSubjectModal = false;
    public bool $classSectionDropdown = false;

    public bool $isClassSectionCategory = false;
    public bool $classSectionCategoryDropdown = false;

    public string $subjectLabel = '-- choose a subject --';
    public bool $isSubjectDropdownOpen = false;

    public string $classSectionId = '';
    public string $classSectionCategoryId = '';
    //public string $subjectId = '' == to remove if no error;
    public array $subjectIds = [];

    public function mount($schoolClass, $classSubjects)
    {
        $this->schoolClass = $schoolClass;

        $this->classArm = $schoolClass->classArm;

        $this->classSubjects = $classSubjects;
    }

    public function render()
    {
        //@todo filter added subjects by class section and class section category
        //$classSubjects = collect($this->schoolClass->subject)->pluck('subject_id');
        //dd($this->classSubjects);
//classArm


        return view('livewire.tenant.classes.add-subject', [
            'classSections' => $this->classArm,//$this->schoolClass->classSection,
            'subjects'      => Subject::query()->get(['uuid', 'subject_name'])->whereNotIn('uuid', $this->classSubjects),
        ]);
    }

    public function store()
    {
        if( ! $this->classSectionId || ! $this->subjectIds){
            return false;
        }

        //@todo add Json array table...[all class section]
        foreach($this->subjectIds as $subjectId){
            (new CreateNewClassSubjectAction())->execute([
                'subject_id'                => $subjectId,
                'class_arm'                 => $this->classSectionId != 'all' ? [] : collect($this->classArm)->pluck('uuid'),
                'school_class_id'           => $this->schoolClass->uuid,
                'class_section_id'          => $this->classSectionId == 'all' ? null : $this->classSectionId ?? null,
                'class_section_category_id' => $this->classSectionCategoryId == 'all' ? null : $this->classSectionCategoryId ?? null,
            ]);
        }

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

    public function selectSubject()
    {
        $this->subjectLabel = $this->subjectIds ? 'Subject selected' : '-- choose a subject --';

    }

    public function onToggleAll(bool $checked)
    {
        $this->subjectIds = $checked ? Subject::query()->pluck('uuid')->toArray() : [];
        $this->subjectLabel = $checked ? 'Select all' : '-- choose a subject --';
        $this->isSubjectDropdownOpen  = ! $checked;
    }

    private function getClassSectionCategory(): void
    {
        $classSectionId = $this->classSectionId;

        $this->classSectionCategories = collect($this->classArm)->filter(function ($item) use($classSectionId){
            return $item->class_section_category_id && $item->class_section_id == $classSectionId
                ? $item['classSectionCategory'] = $item->classSectionCategory
                : [];
        });

        $this->isClassSectionCategory = $this->classSectionCategories->isNotEmpty() && $this->classSectionId != 'all';

    }
}
