<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Illuminate\Support\Collection;
use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Entities\LeaveApprover;
use Lumis\Organization\Entities\FinancialYear;

class LeaveReturnRequestWidget extends LivewireUI
{
    /**
     * @var Collection
     */
    public Collection $pendingLeaves;


    public function __construct()
    {
        parent::__construct();
        $this->pendingLeaves = collect();
    }

    /**
     * @param Staff $staff
     * @param FinancialYear $financialYear
     * @return void
     */
    public function mount(Staff $staff, FinancialYear $financialYear): void
    {
        $leaveApprover = new LeaveApprover($staff, $financialYear);
        $this->pendingLeaves = $leaveApprover->getSubordinateReturns();

    }
    public function confirm(Leave $leave)
    {
        $leave->confirmReturn();
        $leave->save();
        $this->alert('Return request confirmed successfully ');
        $this->redirect(route('leave_application.home'));
    }

    public function render()
    {
        return view('leaveapplication::livewire.leave-return-request-widget');
    }
}
