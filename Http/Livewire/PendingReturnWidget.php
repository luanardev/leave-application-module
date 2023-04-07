<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Illuminate\Support\Collection;
use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Entities\StaffLeave;
use Lumis\Organization\Entities\FinancialYear;

class PendingReturnWidget extends LivewireUI
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
        $this->recentLeaves = $staffLeave->getPendingReturn();
    }

    public function returnback(Leave $leave)
    {
        $leave->requestReturn();
        $leave->save();
        $this->alert('Return request submitted successfully ');
        $this->redirect(route('leave_application.returning'));
    }


    public function render()
    {
        return view('leaveapplication::livewire.pending-return-widget');
    }
}
