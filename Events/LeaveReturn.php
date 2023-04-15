<?php

namespace Lumis\LeaveApplication\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Lumis\LeaveApplication\Entities\Leave;

class LeaveReturn
{
    use Dispatchable, SerializesModels;

    /**
     * @var Leave
     */
    public Leave $leave;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

}
