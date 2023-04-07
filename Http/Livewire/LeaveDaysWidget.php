<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\LeaveType;
use Lumis\LeaveApplication\Entities\StaffLeave;
use Lumis\Organization\Entities\FinancialYear;

class LeaveDaysWidget extends LivewireUI
{
    /**
     * @var LeaveType
     */
    public LeaveType $leaveType;

    /**
     * @var FinancialYear
     */
    public FinancialYear $financialYear;

    /**
     * @var StaffLeave
     */
    private StaffLeave $staffLeave;

    /**
     * @param Staff $staff
     * @param FinancialYear $financialYear
     * @param LeaveType $leaveType
     * @return void
     */
    public function mount(Staff $staff, FinancialYear $financialYear, LeaveType $leaveType): void
    {
        $this->leaveType = $leaveType;
        $this->financialYear = $financialYear;
        $this->staffLeave = new StaffLeave($staff, $financialYear, $leaveType,);
    }

    /**
     * @return mixed
     */
    public function leaveDays(): mixed
    {
        return $this->staffLeave->leaveDays();
    }

    /**
     * @return mixed
     */
    public function daysAllowed(): mixed
    {
        return $this->staffLeave->daysAllowed();
    }

    /**
     * @return mixed
     */
    public function daysTaken(): mixed
    {
        return $this->staffLeave->daysTaken();
    }

    /**
     * @return mixed
     */
    public function daysRemaining(): mixed
    {
        return $this->staffLeave->daysRemaining();
    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('leaveapplication::livewire.leave-days-widget');
    }
}
