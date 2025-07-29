<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Console Kernel
 * 
 * Handles console commands and task scheduling for the Laravel application.
 * Optimized for performance with proper command registration.
 * 
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     * 
     * Configures scheduled tasks for maintenance and optimization.
     * Can be extended to include custom scheduled commands.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // Example scheduled tasks (uncomment as needed):
        
        // Clean up old log files weekly
        // $schedule->command('log:clear')->weekly();
        
        // Generate fresh Swagger documentation daily in production
        // $schedule->command('l5-swagger:generate')->daily()->environments(['production']);
        
        // Clean up temporary files daily
        // $schedule->command('storage:link')->daily();
        
        // Database maintenance (if needed)
        // $schedule->command('queue:work --stop-when-empty')->everyMinute();
    }

    /**
     * Register the commands for the application.
     * 
     * Loads all custom Artisan commands from the Commands directory.
     * Follows Laravel's convention for command auto-discovery.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
