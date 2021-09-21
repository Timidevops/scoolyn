<?php

namespace App\Http\Livewire\Tenant\Student;

use App\Actions\Tenant\File\ExcelFileReaderAction;
use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Student\ClassArm\AttachStudentToClassArmAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidFileFormatException;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\StudentParent;
use App\Models\Tenant\SchoolClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadStudent extends Component
{
    use WithFileUploads;

    public $file;

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

    private array $studentsDetail = [];

    public bool $errorDiv = false;
    public string $errorMessage = '';

    protected $rules = [
        'file' => ['required']
    ];

    public function render()
    {
        return view('livewire.tenant.student.upload-student',[
            'schoolClasses' => SchoolClass::query()->get(['uuid', 'class_name']),
        ]);
    }

    public function store()
    {
        $this->validate();

        if( ! $this->getClassArm() ){
            $this->errorDiv = true;
            $this->errorMessage = 'Kindly select correct class arm';
            return;
        }

        $file = $this->file->store('temp');

        $file = str_replace('temp/', '', $file);

        $format = [
            'first_name',
            'last_name',
            'other_name',
            'gender',
            'dob',
            'address'
        ];

        try {
            $this->studentsDetail = (new ExcelFileReaderAction())->execute($file, $format);
        } catch (FileNotFoundException | InvalidFileFormatException $e) {

            return;
        }

        $dummyParent = StudentParent::withoutGlobalScope('dummyParent')->find(1);

        //add new student with dummy parent..
        foreach ($this->studentsDetail as $student){
            $newStudent = (new CreateNewStudentAction())->execute($dummyParent, [
                'first_name' => $student['first_name'],
                'last_name' => $student['last_name'],
                'other_name' => $student['other_name'],
                'gender' => $student['gender'],
                'dob' => $student['dob'],
                'address' => $student['address'],
                'class_arm' => $this->getClassArm()->uuid,
            ]);

            (new AttachStudentToClassArmAction())->execute($this->getClassArm(), [
                'studentId' => (string) $newStudent->uuid,
            ]);

        }

        //set marker
        (new UpdateTodoItemAction())->execute([
            'name' => OnboardingTodoList::ADD_STUDENT
        ]);

        Session::flash('successFlash', 'Student uploaded successfully!!!');

        $this->redirectRoute('listStudent');
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
