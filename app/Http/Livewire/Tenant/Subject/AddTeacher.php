<?php

namespace App\Http\Livewire\Tenant\Subject;

use App\Actions\Tenant\Subject\SubjectTeacher\CreateNewSubjectTeacherAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Teacher;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class AddTeacher extends Component
{
    public Model $subject;
    public bool $isAddSubjectTeacherModalOpen = false;

    public bool $schoolClassDropdown = false;
    public string $schoolClassLabel = '-- choose a class --';

    public bool $classSectionDropdown = false;
    public string $classSectionLabel = '-- choose a class section --';
    public $classSections = [];

    public bool $isClassSectionCategory = false;
    public string $classSectionCategoryLabel = '-- choose a class section category --';
    public bool $classSectionCategoryDropdown = false;
    public $classSectionCategories = [];

    public bool $teacherDropdown = false;
    public string $teacherLabel = '-- choose a teacher --';

    public string $schoolClassId = '';
    public string $classSectionId = '';
    public string $classSectionCategoryId = '';
    public string $teacherId = '';

    public function render()
    {
        return view('livewire.tenant.subject.add-teacher', [
            'schoolClasses' => SchoolClass::query()->get(['uuid', 'class_name']),
            'teachers' => Teacher::query()->get(['uuid', 'full_name']),
        ]);
    }

    public function mount($subject)
    {
        $this->subject = $subject;
    }

    public function store()
    {
        if( ! $this->schoolClassId || ! $this->teacherId ){
            return false;
        }

        (new CreateNewSubjectTeacherAction())->execute([
            'teacher_id' => $this->teacherId,
            'subject_id' => $this->subject->uuid,
            'school_class_id' => $this->schoolClassId,
            'class_section_id' => $this->classSectionId == 'all' ? null : $this->classSectionId,
            'class_section_category_id' => $this->classSectionCategoryId == 'all' ? null : $this->classSectionCategoryId,
        ]);

        return redirect()->route('listSubjectTeacher',$this->subject->slug);
    }

    public function selectSchoolClass(string $classId, string $className)
    {
        $this->schoolClassId = $classId;

        $this->schoolClassLabel = $className;

        $this->schoolClassDropdown = false;

        $this->classSections = ClassSection::query()->where('school_class_id', $classId)->get();
    }

    public function selectClassSection (string $classSectionId, string $classSectionName)
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

        $this->classSectionCategoryDropdown = false;
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
