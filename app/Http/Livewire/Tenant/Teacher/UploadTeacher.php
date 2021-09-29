<?php

    namespace App\Http\Livewire\Tenant\Teacher;

    use App\Actions\Tenant\File\ExcelFileReaderAction;
    use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
    use App\Actions\Tenant\Teacher\CreateNewTeacherAction;
    use App\Actions\Tenant\User\CreateUserAction;
    use App\Exceptions\FileNotFoundException;
    use App\Exceptions\InvalidFileFormatException;
    use App\Models\Tenant\ClassSubject;
    use App\Models\Tenant\OnboardingTodoList;
    use App\Models\Tenant\SchoolSubject;
    use App\Models\Tenant\StudentParent;
    use App\Models\Tenant\SchoolClass;
    use App\Models\Tenant\User;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Storage;
    use Livewire\Component;
    use Livewire\WithFileUploads;
    use Ramsey\Uuid\Uuid;
    use RecursiveDirectoryIterator;
    use RecursiveIteratorIterator;
    use Spatie\SimpleExcel\SimpleExcelWriter;
    use ZipArchive;

    class UploadTeacher extends Component
    {
        use WithFileUploads;

        public $file;

        private array $teachersDetail = [];

        public bool $errorDiv = false;
        public string $errorMessage = '';

        protected $rules = [
            'file' => ['required']
        ];

        public function render()
        {
            return view('livewire.tenant.teacher.upload-teacher', [
                'schoolClasses' => SchoolClass::query()->get(['slug', 'class_name']),
            ]);
        }
        private function getTeachersExcelFormat()
        {
            return [
                [
                    'fullName' => 'John Doe',
                    'gender' => 'male',
                    'email' => 'jd@scoolyn.com',
                    'staffId' => '001',
                    'phone' => '08099999999',
                    'address' => 'Address',
                    'classSubjectCode' => '',
                ]
            ];
        }
        public function downloadExcelFormat()
        {
            $requestRef = Uuid::uuid4()->toString();
            $fileName = 'ScoolynTeachersUploadFormat_'.$requestRef.'.xlsx';
            File::makeDirectory(Storage::disk('temp')->path($requestRef));
            $pathToFile = Storage::disk('temp')->path($requestRef.'/'.$fileName);
            $teacherFormat = $this->getTeachersExcelFormat();
            SimpleExcelWriter::create($pathToFile)
                ->addRows($teacherFormat);
            return Storage::disk('temp')->download($requestRef.'/'.$fileName);
        }
        private function createClassSubjectsFile(string $requestRef)
        {
            $fileName = 'ScoolynClassSubjects_'.$requestRef.'.xlsx';
            $pathToClassFile = Storage::disk('temp')->path($requestRef.'/'.$fileName);
            $classSubjects = ClassSubject::all();

            $classes = $classSubjects->map(function ($classSub) {
                $classSub['SubjectName'] = $classSub->subject()->exists()? ucwords($classSub->subject->subject_name) : '';
                $classSub['ClassName'] = $classSub->schoolClass->class_name;
                $classSub['ClassSection'] = $classSub->classSection()->exists()? $classSub->classSection->section_name : '';
                $classSub['ClassCategory'] = $classSub->classSectionCategory()->exists()? $classSub->classSectionCategory->section_name : '';
                $classSub['Code'] = $classSub->code;
                return $classSub->only(['SubjectName','ClassName','ClassSection','ClassCategory','Code']);
            });

            SimpleExcelWriter::create($pathToClassFile)
                ->addRows($classes->toArray());
        }
        public function downloadSubjectsAndClassCodes()
        {
            $requestRef = Uuid::uuid4()->toString();
            File::makeDirectory(Storage::disk('temp')->path($requestRef));
            $this->createClassSubjectsFile($requestRef);

            $zipFileName = 'ScoolynClassSubjects_'.$requestRef.'.zip';
            $filesToZipDirectory = Storage::disk('temp')->path($requestRef);

            $zippedFile = $this->zipFilesInFolder($requestRef, $zipFileName, $filesToZipDirectory);
            return Storage::disk('temp')->download($zippedFile);
        }

        private function zipFilesInFolder(string $requestRef, string $zipFileName, string $dirPath)
        {
            $zip_file = $zipFileName;
            $zip = new ZipArchive();
            $zip->open(Storage::disk('temp')->path($zip_file), ZipArchive::CREATE | ZipArchive::OVERWRITE);

            $path = $dirPath;
            if(! File::exists($dirPath)){
                $path = File::makeDirectory($dirPath);
            }
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
            foreach ($files as $name => $file)
            {
                // We're skipping all subfolders
                if (!$file->isDir()) {
                    $filePath     = $file->getRealPath();
                    // extracting filename with substr/strlen
                    $relativePath = $requestRef. '/' . substr($filePath, strlen($path) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
            return $zip_file;
        }
        private function userExist($email, $phone)
        {
            return User::where('email', $email)->orWhere('phone', $phone)->get()->isNotEmpty();
        }
        public function store()
        {
            $this->validate();

            $file = $this->file->store('temp');

            $file = str_replace('temp/', '', $file);

            $format = [
                'full_name',
                'gender',
                'email',
                'staff_id',
                'phone',
                'address',
                'class_subject_code',
            ];

            try {
                $this->teachersDetail = (new ExcelFileReaderAction())->execute($file, $format);
            } catch (FileNotFoundException | InvalidFileFormatException $e) {
                return;
            }

            //add new teacher and attach to class
            try{
                foreach ($this->teachersDetail as $teacher){
                    if(! $this->userExist($teacher['email'], $teacher['phone'])){
                        $password = strtolower(str_replace(' ', '', $teacher['full_name']));

                        if($teacher['phone'] != ''){
                            $password = $teacher['phone'];
                        }
                        $password = Hash::make($password);
                        $user = (new CreateUserAction())->execute([
                            'name' => $teacher['full_name'],
                            'email' => $teacher['email'],
                            'phone' => $teacher['phone'],
                            'password' => $password
                        ]);
                        $newTeacher = (new CreateNewTeacherAction())->execute($user, [
                            'full_name' => $user->name,
                            'email' => $user->email,
                            'staff_id' => $teacher['staff_id'],
                            'address' => $teacher['address'],
                            'gender' => $teacher['gender'],
                        ]);
                    }else{
                        $user = User::where('email', $teacher['email'])->orWhere('phone', $teacher['phone'])->get()->first();
                        $newTeacher = $user->teacher;
                    }

                    //assign teacher to subject
                    $classSubjects = explode(",", trim($teacher['class_subject_code']));

                    foreach($classSubjects as $classSub){
                        $classS = ClassSubject::where('code', $classSub)->get();
                        if($classS->isNotEmpty()){
                            $classS->first()->update([
                                'teacher_id' => $newTeacher->uuid,
                            ]);
                        }
                    }
                }

            }catch(\Exception $exception){
                Log::info("An error occurred while creating teachers via bulk upload. ". $exception->getMessage());
//                DB::rollBack();
            }


            //set marker
            (new UpdateTodoItemAction())->execute([
                'name' => OnboardingTodoList::ADD_TEACHER
            ]);

            Session::flash('successFlash', 'Teacher uploaded successfully!!!');

            $this->redirectRoute('listTeacher');
        }
    }
