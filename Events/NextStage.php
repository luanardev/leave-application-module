<?php

namespace Lumis\LeaveApplication\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Lumis\LeaveApplication\Entities\Approval;

class NextStage
{
    use Dispatchable, SerializesModels;

    /**
     * @var Approval
     */
    public Approval $approval;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
    }

}
