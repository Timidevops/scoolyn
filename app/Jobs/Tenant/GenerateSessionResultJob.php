<?php

namespace App\Jobs\Tenant;

use App\Actions\Tenant\Result\SessionReport\GenerateSessionReportAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateSessionResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Model $classArm;

    /**
     * Create a new job instance.
     *
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
        (new GenerateSessionReportAction())->execute($this->classArm);
    }
}
