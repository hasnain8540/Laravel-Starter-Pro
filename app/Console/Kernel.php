<?php

namespace App\Console;

use App\Console\Commands\TransferOrder;
use App\Console\Commands\TransferOrderReceive;
use App\Console\Commands\{BrlCommand, DropBoxImageImportCron, uploadPartVideosToYoutubeFromDropBox};
use App\Console\Commands\CnyCommand;
use App\Console\Commands\MetalRates;
use App\Console\Commands\EuroCommand;
use App\Console\Commands\CurrenciesCommand;
use App\Console\Commands\InrCommand;
use App\Console\Commands\ThbCommand;
// use App\Traits\GoogleContactTrait;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // use GoogleContactTrait;
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        MetalRates::class,
        CurrenciesCommand::class,
        EuroCommand::class,
        CnyCommand::class,
        InrCommand::class,
        BrlCommand::class,
        ThbCommand::class,
        DropBoxImageImportCron::class,
        uploadPartVideosToYoutubeFromDropBox::class,
        TransferOrderReceive::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('metalrate:update')->twiceDaily(1, 13);
//         // Workin for update all currencies
//         // $schedule->command('currencyrate:update')->twiceDaily(1, 13);
//         $schedule->command('eurorate:update')->twiceDaily(1, 13);
//         $schedule->command('cnyrate:update')->twiceDaily(1, 13);
//         $schedule->command('inrrate:update')->twiceDaily(1, 13);
//         $schedule->command('brlrate:update')->twiceDaily(1, 13);
//         $schedule->command('thbrate:update')->twiceDaily(1, 13);
//         // import images from dropbox
// //         $schedule->command('importDropBox:images')->everyFiveMinutes();
//         $schedule->command('importDropBox:images')->everyMinute();
//         $schedule->command('importUploadPartVideos:DropBox')->everyMinute();
//         $schedule->command('transferOrder:receive')->everyMinute();

//         // for google contact people api
//         $schedule->call(function () {
//           $this->refreshToken();
//         })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
