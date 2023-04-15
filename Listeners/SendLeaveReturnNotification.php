<?php

namespace Lumis\LeaveApplication\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Lumis\LeaveApplication\Events\LeaveReturn;
use Lumis\LeaveApplication\Notifications\LeaveReturnNotification;

class SendLeaveReturnNotification implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param LeaveReturn $event
     * @return void
     */
    public function handle(LeaveReturn $event): void
    {
        $leave = $event->leave;
        $staff = $leave->staff;
        $supervisor = $leave->staff->supervisor;

        $notification = new LeaveReturnNotification($leave, $staff);
        Notification::send($supervisor, $notification);

    }
}
