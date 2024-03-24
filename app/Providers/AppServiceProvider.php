<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;

class AppServiceProvider extends ServiceProvider
{




    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Queue::looping(function () {
            while (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
        });


        Queue::before(function (JobProcessing $event) {
            // ...

            // Log the job processing start time
            Log::info('Job is about to be processed', [
                'start_processing_at' => now(),
                'job_id' => $event->job->getJobId(),
            ]);
        });




        Queue::after(function (JobProcessed $event) {
            // Perform actions after a job is processed
            // Access job information: $event->connectionName, $event->job, $event->job->payload()
            // For example: Log job completion details, update database with job status, etc.

            $jobName = $event->job->resolveName(); // Getting the job class name
            Log::info("Job processed: $jobName");
        });
    }
}
