<?php

namespace App\Console;

use App\Console\Commands\StartChromeDriver;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \App\Console\Commands\OpenDart::class,
        \App\Console\Commands\Kiwoom::class,
        \App\Console\Commands\AutoPost::class,
        \App\Console\Commands\MediumPost::class,
        \App\Console\Commands\WpPost::class,
        \App\Console\Commands\UpdateStockInfo::class,
        \App\Console\Commands\StartChromeDriver::class,
        \Laravelista\LumenVendorPublish\VendorPublishCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command( \App\Console\Commands\MediumPost::class,['theme'])->weekly();
        $schedule->command(\App\Console\Commands\OpenDart::class)->quarterly();
        $schedule->command(\App\Console\Commands\AutoPost::class, ['theme'])->weekly();
        $schedule->command(\App\Console\Commands\AutoPost::class, ['sector'])->weekly();
        $schedule->command(\App\Console\Commands\WpPost::class, ['theme'])->weekly();
        $schedule->command(\App\Console\Commands\WpPost::class, ['sector'])->weekly();
        $schedule->command(\App\Console\Commands\UpdateStockInfo::class, ['theme'])->daily();
        $schedule->command(\App\Console\Commands\UpdateStockInfo::class, ['sector'])->daily();
    }
}
