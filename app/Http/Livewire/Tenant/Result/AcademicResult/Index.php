<?php

namespace App\Http\Livewire\Tenant\Result\AcademicResult;

use App\Jobs\Tenant\GenerateResultJob;
use App\Models\Tenant\AcademicBroadSheet;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Index extends Component
{
    public Collection $classSubjects;
    public Model $classArm;

    public string $totalSubjects;

    public int $totalApprovedBroadsheet = 0;
    public int $totalSubmittedBroadsheet = 0;
    public int $totalAwaitingBroadsheet = 0;
    public int $totalNotApprovedBroadsheet = 0;

    public array $approvedBroadsheets = [];
    public array $submittedBroadsheets = [];
    public array $awaitingBroadsheets = [];
    public array $disapprovedBroadsheets = [];

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

        $finalizedResult =
            $this->classArm->status == ClassArm::RESULT_GENERATED_STATUS
            || $this->classArm->status == ClassArm::SESSION_REPORT_GENERATED_STATUS
            || $this->classArm->status == ClassArm::SESSION_COMPLETED_STATUS;

        return view('livewire.tenant.result.academic-result.index', [
            'finalizedResult' => $finalizedResult,
        ]);
    }

    public function generateResult()
    {
        $schoolLogo = Setting::whereSettingName(Setting::SCHOOL_LOGO)->first();

        if( count(Setting::getSchoolPrincipal()) == 0 || ! $schoolLogo  ){

            Session::flash('warningFlash', 'Error processing request, contact admin.');

            return redirect()->route('singleAcademicResult', $this->classArm->uuid);

        }

        //initial class arm result status;
        $this->classArm->setStatus(ClassArm::GENERATING_RESULT_STATUS);

        GenerateResultJob::dispatch($this->classArm);

        Session::flash('successFlash', 'Result generating!!!');

        return redirect()->route('listAcademicResult');
    }

    private function getTotalValues()
    {
        foreach ($this->classSubjects as $classSubject){

            if( ! $classSubject->academicBroadsheet ){
                $this->totalAwaitingBroadsheet += 1;
                continue;
            }

            $academicBroadsheet = $classSubject->academicBroadsheet()
                ->where('class_arm', $this->classArm->uuid)
                ->where('report_card', Setting::getCurrentCardBreakdownFormat())
                ->first();

            if( $academicBroadsheet ){

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
                ->where('class_arm', $this->classArm->uuid)
                ->where('report_card', Setting::getCurrentCardBreakdownFormat())
                ->first();

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
