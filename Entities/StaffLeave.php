<?php

namespace Lumis\LeaveApplication\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Lumis\StaffManagement\Entities\Employment;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\Organization\Entities\FinancialYear;


class StaffLeave
{

    /**
     * @var LeaveType
     */
    protected LeaveType $leaveType;

    /**
     * @var Staff
     */
    protected Staff $staff;

    /**
     * @var FinancialYear
     */
    protected FinancialYear $financialYear;

    /**
     * @var int
     */
    protected int $period;

    /**
     * @var mixed
     */
    protected mixed $startDate;

    /**
     * @var mixed
     */
    protected mixed $endDate;

    /**
     * @var mixed
     */
    protected mixed $summary;

    /**
     * @var mixed
     */
    protected mixed $document;

    /**
     * @param Staff $staff
     * @param FinancialYear $financialYear
     * @param LeaveType $leaveType
     *
     */
    public function __construct(Staff $staff, FinancialYear $financialYear, LeaveType $leaveType = (new LeaveType))
    {
        $this->staff = $staff;
        $this->financialYear = $financialYear;
        $this->leaveType = $leaveType;

    }

    /**
     * @return LeaveType
     */
    public function leaveType(): LeaveType
    {
        return $this->leaveType;
    }

    /**
     * @return Staff
     */
    public function staff(): Staff
    {
        return $this->staff;
    }

    /**
     * @return FinancialYear
     */
    public function financialYear(): FinancialYear
    {
        return $this->financialYear;
    }

    /**
     * @return int
     */
    public function leaveDays(): int
    {
        if($this->leaveType->isAnnualLeave()){
            return $this->staff->employment->jobGrade()->leaveDays();
        }else{
            return $this->leaveType->getPeriod();
        }

    }

    /**
     * @return int
     */
    public function daysTaken(): int
    {
        return $this->leaveType->leaves()
            ->where('financial_year', $this->financialYear->id)
            ->where('staff_id', $this->staff->id)
            ->where('request_status', 'Completed')
            ->where('approval_status', 'Approved')
            ->select()
            ->sum('period');
    }

    /**
     * @return int
     */
    public function daysRemaining(): int
    {
        return ($this->leaveDays() - $this->daysTaken());
    }

    /**
     * @return float|int
     */
    private function accrualRate(): float|int
    {
        $leaveDays = (int)$this->leaveDays();
        return ($leaveDays/12);
    }

    /**
     * @return float|int
     */
    public function daysAccrued(): float|int
    {
        if($this->leaveType->isAnnualLeave()){

            $financialYear = FinancialYear::getCurrent();
            $today = Carbon::today();
            $openingDate = $financialYear->opening_date;
            $months = intval($openingDate->floatDiffInMonths($today));
            $rate = $this->accrualRate();
            return round($months * $rate);
        }else{
            return 0;
        }
    }

    /**
     * @return float|int
     */
    public function daysAllowed(): float|int
    {
        if($this->leaveType->isAnnualLeave()){
            $daysTaken = $this->daysTaken();
            $daysAccrued = $this->daysAccrued();
            return round($daysAccrued - $daysTaken);
        }else{
            return $this->leaveType->getPeriod();
        }

    }

    /**
     * @return bool
     */
    public function hasLeaveDays(): bool
    {
        return $this->daysRemaining() > 0;
    }

    /**
     * @return bool
     */
    public function hasNoLeaveDays(): bool
    {
        return $this->daysRemaining() == 0;
    }

    /**
     * @return bool
     */
    public function isProcessing(): bool
    {
        $count = Leave::where('type_id', $this->leaveType->id)
            ->where('staff_id', $this->staff->id)
            ->where('financial_year', $this->financialYear->id)
            ->where('request_status', 'Processing')
            ->where('approval_status', 'Pending')
            ->count();
        return $count > 0;
    }

    /**
     * @return bool
     */
    public function isPendingReturn(): bool
    {
        $count = Leave::where('type_id', $this->leaveType->id)
            ->where('staff_id', $this->staff->id)
            ->where('financial_year', $this->financialYear->id)
            ->where('request_status', 'Completed')
            ->where('approval_status', 'Approved')
            ->where('leave_status', 'Inactive')
            ->whereNot('return_status', 'Returned')
            ->count();
        return $count > 0;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        $count = Leave::where('type_id', $this->leaveType->id)
            ->where('staff_id', $this->staff->id)
            ->where('financial_year', $this->financialYear->id)
            ->where('request_status', 'Completed')
            ->where('approval_status', 'Approved')
            ->where('leave_status', 'Active')
            ->count();
        return $count > 0;
    }

    /**
     * @return bool
     */
    public function hasLeaveDraft(): bool
    {
        $draft = $this->getLeaveDraft();
        return $draft != null;
    }

    /**
     * @return null|Leave
     */
    public function getLeaveDraft(): null|Leave
    {
        return Leave::where('staff_id', $this->staff->id)
            ->where('financial_year', $this->financialYear->id)
            ->where('type_id', $this->leaveType->id)
            ->where('request_status', 'Draft')
            ->first();
    }

    /**
     * @return mixed
     */
    public function getRecentLeaves(): mixed
    {
        return Leave::where('staff_id', $this->staff->id)
            ->where('financial_year', $this->financialYear->id)
            ->where('request_status', '<>', 'Draft')
            ->latest()
            ->get();
    }

    /**
     * @return mixed
     */
    public function getRecentDrafts(): mixed
    {
        return Leave::where('staff_id', $this->staff->id)
            ->where('financial_year', $this->financialYear->id)
            ->where('request_status', 'Draft')
            ->latest()
            ->get();
    }

    /**
     * @return mixed
     */
    public function getPendingReturn(): mixed
    {
        return Leave::where('staff_id', $this->staff->id)
            ->where('financial_year', $this->financialYear->id)
            ->where('request_status', 'Completed')
            ->where('approval_status', 'Approved')
            ->where('leave_status', 'Inactive')
            ->whereNot('return_status', 'Returned')
            ->latest()
            ->get();
    }

    /**
     * @return Collection
     */
    public function getColleaguesOnLeave(): Collection
    {
        $colleagues = $this->getColleaguesIds();
        return Leave::whereIn('staff_id', $colleagues)
            ->where('financial_year', $this->financialYear->id)
            ->where('leave_status', 'Active')
            ->latest()
            ->limit(10)
            ->get();
    }

    /**
     * @return Collection
     */
    private function getColleaguesIds(): Collection
    {
        return Employment::where('campus_id', $this->staff->employment->campus_id)
            ->where('department_id', $this->staff->employment->department_id)
            ->where('section_id', $this->staff->employment->section_id)
            ->select('staff_id')
            ->get();
    }


}
