<?php

namespace App\Jobs\Tenant;

use App\Actions\Tenant\Student\ClassArm\ResultSheet\GenerateResultSheetAction;
use App\Actions\Tenant\Student\ClassArm\ResultSheet\GetBroadsheetsAction;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentSubject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Model $classArm;

    /**
     * Create a new job instance.
     *
     *  $classArm
     * @param Model $classArm
     */
    public function __construct(Model $classArm)
    {
        $this->classArm = $classArm;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new GenerateResultSheetAction())->execute($this->classArm);
    }
    public function onQueue($queue)
    {
    }
}
