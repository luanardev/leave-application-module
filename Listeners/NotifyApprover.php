<?php

namespace Lumis\LeaveApplication\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Lumis\LeaveApplication\Events\NextStage;
use Lumis\LeaveApplication\Notifications\LeaveApprovalNotification;

class NotifyApprover implements ShouldQueue
{


    /**
     * Handle the event.
     *
     * @param NextStage $event
     * @return void
     */
    public function handle(NextStage $event): void
    {
        $approval = $event->approval;
        $approver = $approval->nextApprover();
        $leave = $approval->leave;
        if(!empty($approver)){
            $notification = new LeaveApprovalNotification($leave, $approver);
            Notification::send($approver, $notification);
        }




    }
}
