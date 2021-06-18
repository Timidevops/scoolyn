<?php

namespace App\Http\Livewire\Tenant\Subject;

use App\Actions\Tenant\Subject\SubjectTeacher\CreateNewSubjectTeacherAction;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\ClassSectionCategory;
use App\Models\Tenant\ClassSubject;
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

    public Model $classSubject;
    public bool $isClassInfoShow = false;

    public string $classSections = 'nil';
    public string $classSectionCategories = 'nil';

    public bool $teacherDropdown = false;
    public string $teacherLabel = '-- choose a teacher --';

    public string $schoolClassId = '';
    public string $teacherId = '';

    public function render()
    {
        return view('livewire.tenant.subject.add-teacher', [
            'schoolClasses' => $this->subject->classSubject->whereNull('teacher_id'),
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

        // update class subject teacher_id

        $this->classSubject->teacher_id = $this->teacherId;
        $this->classSubject->save();

        return redirect()->route('listSubjectTeacher',$this->subject->slug);
    }

    public function selectSchoolClass(string $classId, string $className)
    {
        $this->schoolClassId = $classId;

        $this->classSubject = $this->subject->classSubject->where('uuid', $classId)->first();

        $this->schoolClassLabel = $className;

        $this->schoolClassDropdown = false;

        if( $this->classSubject->classSection && $this->classSubject->classSectionCategory ){
            $this->classSections = "{$this->classSubject->classSectionType->section_name} - {$this->classSubject->classSectionCategoryType->category_name}";
        }
        elseif ( $this->classSubject->classSection && ! $this->classSubject->classSectionCategory ){
            $this->classSections = $this->classSubject->classSectionType->section_name;
        }
        else{
            $this->classSections = 'All Section';
        }

        $this->isClassInfoShow = true;
    }

    public function selectTeacher(string $teacherId, string $teacherName)
    {
        $this->teacherId = $teacherId;

        $this->teacherLabel = $teacherName;

        $this->teacherDropdown = false;
    }

}
