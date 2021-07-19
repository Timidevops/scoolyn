<?php

namespace App\Http\Livewire\Tenant\Result\AcademicResult;

use App\Jobs\Tenant\GenerateResultJob;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\ClassArm;
use Livewire\Component;

class Index extends Component
{
    public $classSubjects;
    public $classArm;

    public string $totalSubjects;

    public int $totalApprovedBroadsheet = 0;
    public int $totalSubmittedBroadsheet = 0;
    public int $totalAwaitingBroadsheet = 0;
    public int $totalNotApprovedBroadsheet = 0;

    public $approvedBroadsheets = [];
    public $submittedBroadsheets = [];
    public $awaitingBroadsheets = [];
    public $disapprovedBroadsheets = [];

    public function mount($classSubjects, $classArm)
    {
        $this->classSubjects = $classSubjects;

        $this->classArm = $classArm;

        $this->totalSubjects = count($classSubjects);
    }

    public function render()
    {
        $this->getTotalValues();

        $this->getBroadsheets();

        return view('livewire.tenant.result.academic-result.index');
    }

    public function generateResult()
    {
        //initial class arm result status;
       // $this->classArm->setStatus(ClassArm::GENERATING_RESULT_STATUS);

       // dd($this->classArm);
        GenerateResultJob::dispatch($this->classArm);

        $this->redirectRoute('listAcademicResult');
    }

    private function getTotalValues()
    {
        foreach ($this->classSubjects as $classSubject){


           // dd($classSubject->academicBroadsheet->where('class_arm', $this->classArm->uuid)->first());

            if( ! $classSubject->academicBroadsheet ){
                $this->totalAwaitingBroadsheet += 1;
                continue;
            }

            $academicBroadsheet = $classSubject->academicBroadsheet()->where('class_arm', $this->classArm->uuid)->first();

            if( $academicBroadsheet ){

                //dd($classSubject->classArm);

                $this->totalApprovedBroadsheet +=
                    $academicBroadsheet->status == AcademicBroadSheet::APPROVED_STATUS ?
                        1: 0;

                $this->totalSubmittedBroadsheet +=
                    $academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS ?
                       1 : 0;

                $this->totalAwaitingBroadsheet +=
                    $academicBroadsheet->status == AcademicBroadSheet::CREATED_STATUS ?
                        1 : 0;

                $this->totalNotApprovedBroadsheet +=
                    $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ?
                       1 : 0;

              continue;
           }
            $this->totalAwaitingBroadsheet += 1;
        }
    }

    private function getBroadsheets()
    {
        foreach ($this->classSubjects as $classSubject){

            if( ! $classSubject->academicBroadsheet ){
                $this->awaitingBroadsheets [] = $classSubject;
                continue;
            }

            $academicBroadsheet = $classSubject->academicBroadsheet()
                ->where('class_arm', $this->classArm->uuid)->first();

            if($academicBroadsheet){

                if( $academicBroadsheet->status == AcademicBroadSheet::APPROVED_STATUS ){
                    $this->approvedBroadsheets [] = $classSubject;
                }

                if( $academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS ){
                     $this->submittedBroadsheets [] = $classSubject;
                }


                if( $academicBroadsheet->status == AcademicBroadSheet::CREATED_STATUS ){
                    $this->awaitingBroadsheets [] = $classSubject;
                }

                if( $academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ){
                    $this->disapprovedBroadsheets [] = $classSubject;
                }

                continue;
            }
            $this->awaitingBroadsheets [] = $classSubject;
        }
    }
}
