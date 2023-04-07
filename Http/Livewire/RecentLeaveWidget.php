<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Illuminate\Support\Collection;
use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Entities\StaffLeave;
use Lumis\Organization\Entities\FinancialYear;

class RecentLeaveWidget extends LivewireUI
{

    /**
     * @var Collection
     */
    public Collection $recentLeaves;

    public function __construct()
    {
        parent::__construct();
        $this->recentLeaves = collect();
    }

    public function mount(Staff $staff, FinancialYear $financialYear): void
    {
        $staffLeave = new StaffLeave($staff, $financialYear);
        $this->recentLeaves = $staffLeave->getRecentLeaves();
    }

    public function cancel(Leave $leave)
    {
        $leave->cancel();
        $leave->save();
        $this->alert('Leave application cancelled');
        $this->redirect(route('leave_application.home'));
    }

    public function delete(Leave $leave)
    {
        $leave->delete();
        $this->alert('Leave application deleted');
        $this->redirect(route('leave_application.home'));
    }

    public function render()
    {
        return view('leaveapplication::livewire.recent-leave-widget');
    }
}
