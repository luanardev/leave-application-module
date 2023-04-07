<?php

namespace Lumis\LeaveApplication\Providers;

use Illuminate\Support\ServiceProvider;
use Lumis\LeaveApplication\Console\EndLeaveCommand;
use Lumis\LeaveApplication\Console\RemindApprovalCommand;
use Lumis\LeaveApplication\Console\RemindEndDateCommand;
use Lumis\LeaveApplication\Console\RemindReturnBackCommand;
use Lumis\LeaveApplication\Console\StartLeaveCommand;


class CommandServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StartLeaveCommand::class,
                EndLeaveCommand::class,
                RemindApprovalCommand::class,
                RemindEndDateCommand::class,
                RemindReturnBackCommand::class
            ]);
        }

    }
}
