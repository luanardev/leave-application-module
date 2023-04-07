<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Illuminate\Support\Collection;
use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\StaffLeave;
use Lumis\Organization\Entities\FinancialYear;

class StaffOnLeave extends LivewireUI
{
    /**
     * @var Collection
     */
    public Collection $staffOnLeave;

    public function __construct()
    {
        parent::__construct();
        $this->staffOnLeave = collect();
    }

    /**
     * @param Staff $staff
     * @param FinancialYear $financialYear
     * @return void
     */
    public function mount(Staff $staff, FinancialYear $financialYear): void
    {
        $staffLeave = new StaffLeave($staff, $financialYear);
        $this->staffOnLeave = $staffLeave->getColleaguesOnLeave();
    }

    public function render()
    {
        return view('leaveapplication::livewire.staff-on-leave');
    }
}
