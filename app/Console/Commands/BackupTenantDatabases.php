<?php

namespace App\Console\Commands;

use App\Models\Tenant\ScoolynTenant;
use App\Services\BackupJobFactory;
use Illuminate\Console\Command;
use Spatie\Backup\Events\BackupHasFailed;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Backup\Commands\BackupCommand as SpatieBackupCommand;

class BackupTenantDatabases extends SpatieBackupCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:tenants {--disable-notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Tenant databases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        consoleOutput()->comment('Starting backup...');
        $disableNotifications = $this->option('disable-notifications');

        try {
            $backupJob = BackupJobFactory::createFromArray(config('backup'));

            if ($disableNotifications) {
                $backupJob->disableNotifications();
            }

            $backupJob->run();

            consoleOutput()->comment('Backup completed!');

        } catch (\Exception $exception) {
            consoleOutput()->error("Backup failed because: {$exception->getMessage()}.");

            if (! $disableNotifications) {
                event(new BackupHasFailed($exception));
            }

            return 1;
        }
    }
}
