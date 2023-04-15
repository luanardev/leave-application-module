<?php

namespace Lumis\LeaveApplication\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Lumis\LeaveApplication\Events\LeaveCreated;
use Lumis\LeaveApplication\Notifications\LeaveRequestNotification;

class SendLeaveRequestNotification implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param LeaveCreated $event
     * @return void
     */
    public function handle(LeaveCreated $event): void
    {
        $leave = $event->leave;
        $staff = $leave->staff;

        $notification = new LeaveRequestNotification($leave, $staff);
        Notification::send($staff, $notification);

    }
}
