<?php

namespace Lumis\LeaveApplication\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Notifications\LeaveActivatedNotification;

class StartLeave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $leaves = Leave::startingToday();

        if (count($leaves)){
            foreach ($leaves as $leave) {
                // send leave start notification
                if ($leave instanceof Leave) {
                    $leave->activate()->save();
                    $notification = new LeaveActivatedNotification($leave);
                    Notification::send($leave->staff, $notification);
                }
            }
        }


    }
}
