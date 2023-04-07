<?php

namespace Lumis\LeaveApplication\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('leave:start')->daily();
            $schedule->command('leave:end')->daily();
            $schedule->command('leave:remind-approval')->hourly();
            $schedule->command('leave:remind-end')->daily();
            $schedule->command('leave:remind-return')->daily();
        });
    }

}
