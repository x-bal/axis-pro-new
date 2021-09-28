<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CronSatu::class,
        Commands\CronDua::class,
        Commands\CronTiga::class,
        Commands\CronEmpat::class,
        Commands\CronLima::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cron:satu')->everyMinute();
        $schedule->command('cron:dua')->everyMinute();
        $schedule->command('cron:tiga')->everyMinute();
        $schedule->command('cron:empat')->everyMinute();
        $schedule->command('cron:lima')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
