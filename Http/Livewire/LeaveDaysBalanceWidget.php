<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\LeaveType;
use Lumis\LeaveApplication\Entities\StaffLeave;
use Lumis\Organization\Entities\FinancialYear;

class LeaveDaysBalanceWidget extends LivewireUI
{
    /**
     * @var FinancialYear
     */
    public FinancialYear $financialYear;

    /**
     * @var Staff
     */
    public Staff $staff;

    /**
     * @var string
     */
    public string $calendarUnit;

    /**
     * @var array
     */
    public array $staffLeaves;

    /**
     * @param Staff $staff
     * @param FinancialYear $financialYear
     * @param string $calendarUnit
     * @return void
     */
    public function mount(Staff $staff, FinancialYear $financialYear, string $calendarUnit = 'DAYS'): void
    {
        $this->financialYear = $financialYear;
        $this->staff = $staff;
        $this->calendarUnit = $calendarUnit;

        $leaveTypes = LeaveType::all();

        foreach ($leaveTypes as $leaveType) {
            $this->staffLeaves[] = new StaffLeave($staff, $financialYear, $leaveType);
        }
    }

    public function render()
    {
        return view('leaveapplication::livewire.leave-days-balance-widget');
    }
}
