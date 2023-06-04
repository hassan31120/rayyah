<?php

namespace App\Console;

use App\Console\Commands\ClearCacheCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->exec('php artisan cache:clear');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        ClearCacheCommand::class;

        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
