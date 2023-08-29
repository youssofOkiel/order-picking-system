<?php

namespace App\Console;

use App\Jobs\ProcessAssignOrderToNearestTimeSlot;
use App\Jobs\ProcessAutoPickerAssignment;
use App\Jobs\ProcessCheckCompletedOrder;
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
        $schedule->job(new ProcessAutoPickerAssignment())->everyMinute();
        $schedule->job(new ProcessCheckCompletedOrder())->everyMinute();
        $schedule->job(new ProcessAssignOrderToNearestTimeSlot())->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
