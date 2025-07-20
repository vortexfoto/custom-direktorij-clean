<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Registriraj Artisan ukaze.
     */
    protected $commands = [
        \App\Console\Commands\AddCustomWebsiteUrl::class,
    ];

    /**
     * Definiraj urnik (cron) za ukaze.
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Registriraj ukaze aplikacije.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
