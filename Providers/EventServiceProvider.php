<?php

namespace Lumis\LeaveApplication\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Events\LeaveApproved;
use Lumis\LeaveApplication\Events\LeaveCreated;
use Lumis\LeaveApplication\Events\NextStage;
use Lumis\LeaveApplication\Listeners\NotifyApprover;
use Lumis\LeaveApplication\Listeners\NotifySupervisor;
use Lumis\LeaveApplication\Listeners\SendLeaveApprovedNotification;
use Lumis\LeaveApplication\Listeners\SendLeaveRequestNotification;
use Lumis\LeaveApplication\Observers\LeaveObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        LeaveCreated::class => [
            SendLeaveRequestNotification::class,
            NotifySupervisor::class
        ],

        NextStage::class => [
            NotifyApprover::class,
        ],

        LeaveApproved::class => [
            SendLeaveApprovedNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Leave::observe(
            LeaveObserver::class
        );
    }


}
