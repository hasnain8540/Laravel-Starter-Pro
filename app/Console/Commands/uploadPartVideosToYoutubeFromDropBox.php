<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Repositories\DropBox\DropBoxInterface;

class uploadPartVideosToYoutubeFromDropBox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importUploadPartVideos:DropBox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload part videos from dropbox account to youtube';

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
    public function handle(DropBoxInterface $dropbox)
    {
        $jobExistsAlready = checkTaskInJobsTable("App\Jobs\DropBox\ImportPartVideosDropBoxJob");
        // check the quota of the youtube api account
        if ($jobExistsAlready != 1 && $this->quotaStatus() == 1) {
            return $dropbox->importVideosDropbox();
        }
    }


    public function quotaStatus()
    {
        $record =  \DB::table("youtube_access_tokens")->first();
        if(!$record){
              return 0;
        }else{
             $recordDate = $record->created_at;
             $recordDate = explode(' ',$recordDate);
             $recordDate = current($recordDate);
             if($recordDate == Carbon::today()->toDateString() ){
                     if($record->available_quota_points >=1600){
                         return 1;
                     }else{
                         return 0;
                     }
             }else{
                     return 1;
             }
        }
    }
}
