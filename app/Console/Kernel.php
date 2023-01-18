<?php

namespace App\Console;

use App\Console\Commands\GenerateDomainSuggestionsJsonCommand;
use App\Console\Commands\UpdateSuccessStoriesCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(GenerateDomainSuggestionsJsonCommand::class)->weeklyOn(7, '3:00');
        $schedule->command(UpdateSuccessStoriesCommand::class)->weeklyOn('3:15');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
