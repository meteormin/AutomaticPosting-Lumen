<?php

namespace App\Console;

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
        $schedule->command(\App\Console\Commands\AutoPost::class)->weekly();
        $schedule->command(\App\Console\Commands\UpdateStockInfo::class, ['theme'])->daily();
        $schedule->command(\App\Console\Commands\UpdateStockInfo::class, ['sector'])->daily();
    }
}
