<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Luanardev\LivewireUI\LivewireUI;
use Lumis\LeaveApplication\Entities\Leave;

class LeaveDetails extends LivewireUI
{
    /**
     * @var Leave
     */
    public Leave $leave;

    /**
     * @param Leave $leave
     * @return void
     */
    public function mount(Leave $leave)
    {
        $this->leave = $leave;
    }

    public function render()
    {
        return view('leaveapplication::livewire.leave-details');
    }
}
