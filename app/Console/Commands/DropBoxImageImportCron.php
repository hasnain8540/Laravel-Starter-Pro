<?php

namespace App\Console\Commands;

use App\Repositories\DropBox\DropBoxInterface;
use Illuminate\Console\Command;
use Log;

class DropBoxImageImportCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importDropBox:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import images from dropbox account';

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
    public function handle(DropBoxInterface $dropBoxRepository)
    {
        $jobExistsAlready = checkTaskInJobsTable("App\Jobs\DropBox\ImportBatchImagesJob");
        if ($jobExistsAlready != 1) {
            return $dropBoxRepository->importImagesFromDropBox();
        }
    }

}
