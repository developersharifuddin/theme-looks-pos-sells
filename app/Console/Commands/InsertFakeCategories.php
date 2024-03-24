<?php
// app/Console/Commands/InsertFakeCategories.php
namespace App\Console\Commands;

use App\Batch\CategoryBatch;
use App\Jobs\CategoryInsertJob;
use Illuminate\Console\Command;

class InsertFakeCategories extends Command
{
    protected $signature = 'insert:fake-categories';
    protected $description = 'Insert fake categories into the database';

    public function handle()
    {
        $batchSize = 200; // Adjust as needed
        $totalRecords = 1000; // 1 million records
        CategoryInsertJob::dispatch($batchSize, $totalRecords);
        $this->info('Fake categories insertion job dispatched to the queue.');

        // $categoryBatch = new CategoryBatch($batchSize, $totalRecords);
        // $categoryBatch->insertFakeCategories();  when only batch processor work then its uncommend. when add jobs.php file then it commend.
        // $this->info('Fake categories inserted successfully.');
    }
}
