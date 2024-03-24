<?php

namespace App\Console;

use Illuminate\Support\Facades\Log;

use App\Mail\TaskFailedNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuccessfulTaskNotification;
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
        $schedule->command('email:daily')->daily()->before(function () {
            // Actions before the task execution
            Log::info('Preparing to execute the emails:send command.');
        })
            ->after(function () {
                // Actions after the task execution
                Log::info('The emails:send command has executed.');
            });

        $schedule->command('email:daily')
            ->timezone('Asia/Dhaka')
            ->hourly()
            ->between('0:00', '24:00')
            ->before(function () {
                // Actions before the task execution
                Log::info('Preparing to execute the emails:send command.');
            })
            ->after(function () {
                // Actions after the task execution
                Log::info('The emails:send command has executed.');
            })
            ->onSuccess(function () {
                // Actions to perform when the task succeeds
                Log::info('The emails:send command succeeded.');

                // For example, notify an administrator via email about the successful execution
                $adminEmail = 'admin@example.com';
                Mail::to($adminEmail)->send(new \App\Mail\SuccessfulTaskNotification());
            })
            ->onFailure(function () {
                // Actions to perform when the task fails
                Log::error('The emails:send command failed.');

                // For example, send an alert email to the support team in case of failure
                $supportEmail = 'support@example.com';
                Mail::to($supportEmail)->send(new \App\Mail\TaskFailedNotification());
            });
    }
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        Commands\InsertRoutePermissions::class,
    ];
}
