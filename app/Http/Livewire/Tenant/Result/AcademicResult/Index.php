<?php

namespace App\Http\Livewire\Tenant\Result\AcademicResult;

use App\Models\Tenant\AcademicBroadSheet;
use Livewire\Component;

class Index extends Component
{
    public $classSubjects;
    public string $totalSubjects;

    public int $totalSubmittedBroadsheet = 0;
    public int $totalAwaitingBroadsheet = 0;
    public int $totalNotApprovedBroadsheet = 0;

    public $submittedBroadsheets = [];
    public $awaitingBroadsheets = [];

    public function mount($classSubjects)
    {
        $this->classSubjects = $classSubjects;

        $this->totalSubjects = count($classSubjects);
    }

    public function render()
    {
        $this->getTotalValues();

        $this->getBroadsheets();

        return view('livewire.tenant.result.academic-result.index');
    }

    private function getTotalValues()
    {
        foreach ($this->classSubjects as $classSubject){

            if( $classSubject->academicBroadsheet ){

                $this->totalSubmittedBroadsheet +=
                    $classSubject->academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS ?
                       1 : 0;

                $this->totalNotApprovedBroadsheet +=
                    $classSubject->academicBroadsheet->status == AcademicBroadSheet::NOT_APPROVED_STATUS ?
                       1 : 0;

              continue;
           }
            $this->totalAwaitingBroadsheet += 1;
        }
    }

    private function getBroadsheets()
    {
        foreach ($this->classSubjects as $classSubject){

            if($classSubject->academicBroadsheet){

                if($classSubject->academicBroadsheet->status == AcademicBroadSheet::SUBMITTED_STATUS) {
                     $this->submittedBroadsheets [] = $classSubject;
                }


                if($classSubject->academicBroadsheet->status == AcademicBroadSheet::CREATED_STATUS ){
                    $this->awaitingBroadsheets [] = $classSubject;
                }

                continue;
            }
            $this->awaitingBroadsheets [] = $classSubject;
        }
    }
}
