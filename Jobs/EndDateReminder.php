<?php

namespace Lumis\LeaveApplication\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Notifications\LeaveEndDateReminder;

class EndDateReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $leaves = Leave::endingToday();
        if(count($leaves)){
            foreach ($leaves as $leave) {
                // send end date reminder
                if ($leave instanceof Leave) {
                    $notification = new LeaveEndDateReminder($leave);
                    Notification::send($leave->staff, $notification);
                }
            }
        }

    }
}
