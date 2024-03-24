<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\BatchDataInsertJob;

class BatchDataInsertCommand extends Command
{

    protected $signature = 'batch:data-insert';
    protected $description = 'Insert fake data for the "brands" table';

    public function handle()
    {
        $totalRecords = 2000; // Total records to insert for each model
        $chunkSize = 400; // Adjust the batch size as needed
        $insertCount = 1;


        for ($i = 1; $i < $totalRecords; $i += $chunkSize) {

            for ($j = 1; $j <= $chunkSize; $j++) {
                $inserted = $j * $insertCount;
                $this->info("Batch processing started. Data Inserting...");
                $this->info("Inserted Insert Count Chunksize  $insertCount & Inserted  $inserted to $totalRecords records into the database.");
            }
            $insertCount++;

            // $count = $this->argument('count');
            // $this->info("Dispatching the job to insert $count fake Brand records...");
            // InsertBrandDataJob::dispatchNow($count); // Change dispatch to dispatchNow
            // $this->info("Job executed synchronously.");

            // $batchSize = 100; // Adjust the batch size as needed
            // $this->output->progressStart(1000);
            // Brand::withoutEvents(function () use ($batchSize) {
            //     factory(Brand::class, $batchSize)->create();
            // });
            // $this->output->progressFinish();


            dispatch(new BatchDataInsertJob());
            // dispatch(new BatchDataInsertJob())->onQueue('batch:data-insert');

            // dispatch(new BatchDataInsertJob($chunkSize, $totalRecords));
            $this->info('Job queued successfully.');
        }
    }
}
