<?php

namespace App\Http\Livewire\Tenant\Student;

use App\Actions\Tenant\File\ExcelFileReaderAction;
use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
use App\Actions\Tenant\Student\AttachSubjectsToStudents;
use App\Actions\Tenant\Student\ClassArm\AttachStudentToClassArmAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidFileFormatException;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\OnboardingTodoList;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentParent;
use App\Models\Tenant\SchoolClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Ramsey\Uuid\Uuid;
use Spatie\SimpleExcel\SimpleExcelWriter;

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
    protected $messages = [
        'file.required' => 'Select a file to upload.',
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
            'student_id',
            'gender',
            'dob',
            'address',
            'parent_code',
        ];

        try {
            $this->studentsDetail = (new ExcelFileReaderAction())->execute($file, $format);
        } catch (FileNotFoundException | InvalidFileFormatException $e) {
            session()->flash('errorMessage', 'Invalid file format. Kindly download and use the valid format.');
            Log::info("Error while uploading students file ". $e->getMessage());
            return;
        }

        $studentParent = StudentParent::withoutGlobalScope('dummyParent')->find(1);

        //add new student with dummy parent..
        foreach ($this->studentsDetail as $student){
            if($this->studentExist($student['first_name'], $student['last_name'], $student['student_id'])){
                continue;
            }
            $parent = StudentParent::query()->where('code', $student['parent_code'])->get();

            if($parent->isNotEmpty()){
                $studentParent = $parent->first();
            }

            $newStudent = (new CreateNewStudentAction())->execute($studentParent, [
                'first_name' => $student['first_name'],
                'last_name' => $student['last_name'],
                'other_name' => $student['other_name'],
                'gender' => $student['gender'],
                'dob' => $student['dob'],
                'address' => $student['address'],
                'class_arm' => $this->getClassArm()->uuid,
                'matriculation_number' => $student['student_id'],
            ]);

            (new AttachStudentToClassArmAction())->execute($this->getClassArm(), [
                'studentId' => (string) $newStudent->uuid,
            ]);

            (new AttachSubjectsToStudents($newStudent))->execute();
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

    private function getStudentsExcelFormat()
    {
        return [
            [
                'FirstName' => 'John',
                'LastName' => 'Doe',
                'OtherName' => 'James',
                'StudentId' => '123456789',
                'Gender' => 'male',
                'DOB' => '12/09/2011',
                'Address' => '186, Obafemi Awolowo Way, Oke-Ado, Ibadan',
                'parentCode' => '0315947',
            ]
        ];
    }
    public function downloadExcelFormat()
    {
        $requestRef = Uuid::uuid4()->toString();
        $fileName = 'ScoolynStudentsUploadFormat_'.$requestRef.'.xlsx';
        File::makeDirectory(Storage::disk('temp')->path($requestRef));
        $pathToFile = Storage::disk('temp')->path($requestRef.'/'.$fileName);
        $studentFormat = $this->getStudentsExcelFormat();
        SimpleExcelWriter::create($pathToFile)
            ->addRows($studentFormat);
        return Storage::disk('temp')->download($requestRef.'/'.$fileName);
    }
    public function downloadParentCodes()
    {
        $requestRef = Uuid::uuid4()->toString();
        $fileName = 'ScoolynParentCodes_'.$requestRef.'.xlsx';
        File::makeDirectory(Storage::disk('temp')->path($requestRef));
        $pathToFile = Storage::disk('temp')->path($requestRef.'/'.$fileName);
        $parents = StudentParent::all('title','first_name','last_name','phone_number','code')->toArray();
        SimpleExcelWriter::create($pathToFile)
            ->addRows($parents);
        return Storage::disk('temp')->download($requestRef.'/'.$fileName);
    }

    private function studentExist($firstName, $lastName, $studentId)
    {
        return Student::where('first_name', $firstName)->where('last_name', $lastName)->where('matriculation_number', $studentId)->get()->isNotEmpty();
    }
}
