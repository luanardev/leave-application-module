<?php

namespace Lumis\LeaveApplication\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Lumis\LeaveApplication\Events\LeaveApproved;
use Lumis\LeaveApplication\Notifications\LeaveApprovedNotification;

class SendLeaveApprovedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param LeaveApproved $event
     * @return void
     */
    public function handle(LeaveApproved $event): void
    {
        $leave = $event->leave;
        $staff = $leave->staff;

        $notification = new LeaveApprovedNotification($leave, $staff);
        Notification::send($staff, $notification);
    }
}
