<?php

namespace Lumis\LeaveApplication\Observers;

use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Events\LeaveCreated;

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
