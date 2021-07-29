<?php

namespace App\Http\Livewire\Tenant\Classes;

use App\Models\Tenant\ClassArm;
use App\Models\Tenant\ClassSection;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
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
            'classSections' => $this->schoolClass->classArm()->whereNull('class_teacher')->get(),
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
            return back();
        }


        if( $this->classSectionId == 'all' ){
           $classArms = ClassArm::query()->where('school_class_id', $this->schoolClass->uuid)->get();

           foreach ($classArms as $classArm){
                $this->attachClassTeacher($classArm);
           }
        }
        elseif( $this->classSectionCategoryId == 'all' ){
            $classArms = ClassArm::query()
                ->where('school_class_id', $this->schoolClass->uuid)
                ->where('class_section_id', $this->classSectionId)->get();

            foreach ($classArms as $classArm){
                $this->attachClassTeacher($classArm);
            }
        }
        else{
            $classArm = ClassArm::query()
                ->where('school_class_id', $this->schoolClass->uuid)
                ->where('class_section_id', $this->classSectionId)
                ->where('class_section_category_id', $this->classSectionCategoryId)->first();

            if( $classArm ){

                $classArm->class_teacher = (string) $this->teacherId;

                $classArm->save();
            }
        }

        Teacher::whereUuid($this->teacherId)->user->assignRole(User::CLASS_TEACHER_USER);

        Session::flash('successFlash', 'Class teacher added successfully!!!');

        return redirect()->route('classTeacher',$this->schoolClass->slug);
    }

    private function attachClassTeacher($classArm)
    {
        $classArm->class_teacher = $this->teacherId;

        $classArm->save();
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
