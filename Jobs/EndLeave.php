<?php

namespace Lumis\LeaveApplication\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Lumis\LeaveApplication\Entities\Leave;

class EndLeave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
                // send leave start notification
                if ($leave instanceof Leave) {
                    $leave->deactivate()->save();
                }
            }
        }


    }
}
