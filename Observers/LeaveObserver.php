<?php

namespace Lumis\LeaveApplication\Observers;

use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Events\LeaveCreated;
use Lumis\LeaveApplication\Events\LeaveReturn;

class LeaveObserver
{


    /**
     * Handle the "created" event.
     *
     * @param Leave $leave
     * @return void
     */
    public function created(Leave $leave): void
    {
        LeaveCreated::dispatch($leave);
    }

    /**
     * Handle the "updated" event.
     *
     * @param Leave $leave
     * @return void
     */
    public function updated(Leave $leave): void
    {
        if($leave->isReturning()){
            LeaveReturn::dispatch($leave);
        }

    }

    /**
     * Handle the Staff "deleted" event.
     *
     * @param Leave $leave
     * @return void
     */
    public function deleted(Leave $leave): void
    {

    }


}
