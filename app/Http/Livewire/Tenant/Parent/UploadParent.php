<?php

    namespace App\Http\Livewire\Tenant\Parent;

    use App\Actions\Tenant\File\ExcelFileReaderAction;
    use App\Actions\Tenant\OnboardingTodo\UpdateTodoItemAction;
    use App\Actions\Tenant\Parent\CreateNewParentAction;
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

    class UploadParent extends Component
    {
        use WithFileUploads;

        public $file;

        private array $parentsDetail = [];

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
            return view('livewire.tenant.parent.upload-parent');
        }
        private function getParentsExcelFormat()
        {
            return [
                [
                    'FirstName' => 'John',
                    'LastName' => 'Doe',
                    'Gender' => 'male',
                    'Email' => 'jd@scoolyn.com',
                    'PhoneNumber' => '08099999999',
                    'Address' => 'Address',
                ]
            ];
        }
        public function downloadExcelFormat()
        {
            $requestRef = Uuid::uuid4()->toString();
            $fileName = 'ScoolynParentsUploadFormat_'.$requestRef.'.xlsx';
            File::makeDirectory(Storage::disk('temp')->path($requestRef));
            $pathToFile = Storage::disk('temp')->path($requestRef.'/'.$fileName);
            $teacherFormat = $this->getParentsExcelFormat();
            SimpleExcelWriter::create($pathToFile)
                ->addRows($teacherFormat);
            return Storage::disk('temp')->download($requestRef.'/'.$fileName);
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
                'first_name',
                'last_name',
                'gender',
                'email',
                'phone_number',
                'address',
            ];

            try {
                $this->parentsDetail = (new ExcelFileReaderAction())->execute($file, $format);

            } catch (FileNotFoundException | InvalidFileFormatException $e) {
                Log::info("Error while uploading file. ". $e->getMessage());
            }

            //add new teacher and attach to class
            try{
                foreach ($this->parentsDetail as $parent) {
                    if (! $this->userExist($parent['email'], $parent['phone_number'])) {
                        $password = "password";

                        if ($parent['phone_number'] != '') {
                            $password = $parent['phone_number'];
                        }
                        $password = Hash::make($password);
                        try{
                            DB::beginTransaction();
                                $user = (new CreateUserAction())->execute([
                                'name' => $parent['first_name'] . ' ' . $parent['last_name'],
                                'email' => $parent['email'],
                                'phone' => $parent['phone_number'],
                                'password' => $password
                            ]);
                                $user->assignRole(User::PARENT_USER);
                                (new CreateNewParentAction())->execute($user, [
                                'first_name' => $parent['first_name'],
                                'last_name' => $parent['last_name'],
                                'phone_number' => $parent['phone_number'],
                                'gender' => $parent['gender'],
                                'email' => $user->email,
                                'address' => $parent['address'],
                            ]);
                            DB::commit();
                        }catch (\Exception $e){
                            Log::info("Error during bulk upload. --" . $e->getMessage());
                            DB::rollBack();
                        }
                    }
                }
            }catch(\Exception $exception){
                Log::info("An error occurred while creating parents via bulk upload. ". $exception->getMessage());
            }


            //set marker
            (new UpdateTodoItemAction())->execute([
                'name' => OnboardingTodoList::ADD_PARENT
            ]);

            Session::flash('successFlash', 'Teacher uploaded successfully!!!');

            $this->redirectRoute('listParent');
        }

    }
