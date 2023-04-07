<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Illuminate\Support\Collection;
use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\LeaveApprover;
use Lumis\Organization\Entities\FinancialYear;

class LeaveAwaitingApproval extends LivewireUI
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
        if ($leaveApprover->isSupervisor()) {
            $this->pendingLeaves = $leaveApprover->getSupervisorRequests();
        } elseif ($leaveApprover->isApprover()) {
            $this->pendingLeaves = $leaveApprover->getApproverRequests();
        }
    }

    public function render()
    {
        return view('leaveapplication::livewire.leave-awaiting-approval');
    }
}
