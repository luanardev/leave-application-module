<?php

namespace Lumis\LeaveApplication\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Lumis\LeaveApplication\Events\LeaveReturn;
use Lumis\LeaveApplication\Notifications\LeaveApprovalNotification;

class NotifySupervisor implements ShouldQueue
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
        $supervisor = $leave->staff->supervisor;

        if(!empty($supervisor)){
            $notification = new LeaveApprovalNotification($leave, $supervisor);
            Notification::send($supervisor, $notification);
        }




    }
}
