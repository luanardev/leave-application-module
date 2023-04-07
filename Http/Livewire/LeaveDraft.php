<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Illuminate\Support\Collection;
use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Entities\StaffLeave;
use Lumis\Organization\Entities\FinancialYear;

class LeaveDraft extends LivewireUI
{

    /**
     * @var Collection
     */
    public Collection $draftLeaves;

    public function __construct()
    {
        parent::__construct();
        $this->draftLeaves = collect();
    }

    public function mount(Staff $staff, FinancialYear $financialYear): void
    {
        $staffLeave = new StaffLeave($staff, $financialYear);
        $this->draftLeaves = $staffLeave->getRecentDrafts();
    }

    public function delete(Leave $leave)
    {
        $leave->delete();
        $this->alert('Leave draft deleted');
        $this->redirect(route('leave_application.home'));
    }

    public function render()
    {
        return view('leaveapplication::livewire.leave-draft');
    }
}
