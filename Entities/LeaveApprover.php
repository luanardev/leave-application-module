<?php

namespace Lumis\LeaveApplication\Entities;

use Lumis\StaffManagement\Entities\Staff;
use Lumis\Organization\Entities\FinancialYear;

class LeaveApprover
{
    /**
     * @var Staff
     */
    protected Staff $staff;

    /**
     * @var FinancialYear
     */
    protected FinancialYear $financialYear;

    /**
     * @param Staff $staff
     * @param FinancialYear $financialYear
     */
    public function __construct(Staff $staff, FinancialYear $financialYear)
    {
        $this->staff = $staff;
        $this->financialYear = $financialYear;
    }

    /**
     * @return bool
     */
    public function canMakeApprovals(): bool
    {
        if ($this->isApprover()) {
            return true;
        } elseif ($this->isSupervisor()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isApprover(): bool
    {
        $records = Approver::where('staff_id', $this->staff->id)
            ->where('campus_id', $this->staff->employment->campus_id)
            ->get();
        return count($records) > 0;
    }

    /**
     * @return bool
     */
    public function isSupervisor(): bool
    {
        return $this->staff->isSupervisor();
    }

    /**
     * @param Leave $leave
     * @return bool
     */
    public function canApprove(Leave $leave): bool
    {
        $approver = Approver::where('staff_id', $this->staff->id)->first();
        if (empty($approver)) {
            return false;
        }
        if ($approver->stage_id == $leave->stage_id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Leave $leave
     * @return bool
     */
    public function hasApproved(Leave $leave): bool
    {
        return $leave->isApprovedBy($this->staff);
    }

    /**
     * @return Approver
     */
    public function approver(): Approver
    {
        return Approver::where('staff_id', $this->staff->id)
            ->where('campus_id', $this->staff->employment->campus_id)
            ->first();
    }

    /**
     * @return mixed
     */
    public function getSupervisorRequests(): mixed
    {
        $query = "SELECT app_leave_applications.*
			FROM app_leave_applications
			JOIN app_employees_staff_supervision
			WHERE app_leave_applications.staff_id = app_employees_staff_supervision.subordinate_id
			AND app_employees_staff_supervision.supervisor_id = ?
			AND app_leave_applications.stage_id = ?
			AND app_leave_applications.request_status = 'Processing'
            AND app_leave_applications.approval_status = 'Pending'
            AND app_leave_applications.leave_status = 'Pending'
			AND app_leave_applications.id NOT IN (
                SELECT app_leave_approvals.leave_id
                FROM app_leave_approvals
                WHERE app_leave_approvals.leave_id = app_leave_applications.id
                AND app_leave_approvals.stage_id = app_leave_applications.stage_id
            )";

        return Leave::fromQuery($query, [
            $this->staff->getKey(),
            Stage::default()->getKey()
        ]);
    }

    /**
     * @return mixed
     */
    public function getApproverRequests(): mixed
    {
        $query = "SELECT app_leave_applications.*
			FROM app_leave_applications
			JOIN app_leave_approvers
			WHERE app_leave_applications.stage_id = app_leave_approvers.stage_id
			AND app_leave_approvers.staff_id = ?
			AND app_leave_applications.request_status = 'Processing'
            AND app_leave_applications.approval_status = 'Pending'
            AND app_leave_applications.leave_status = 'Pending'
			AND app_leave_applications.staff_id != app_leave_approvers.staff_id
			AND app_leave_applications.campus_id = app_leave_approvers.campus_id
			AND app_leave_applications.id NOT IN (
                SELECT app_leave_approvals.leave_id
                FROM app_leave_approvals
                WHERE app_leave_approvals.leave_id = app_leave_applications.id
                AND app_leave_approvals.stage_id = app_leave_applications.stage_id
            )";

        return Leave::fromQuery($query, [$this->staff->getKey()]);
    }

    /**
     * @return mixed
     */
    public function getSubordinateReturns(): mixed
    {
        $query = "SELECT app_leave_applications.*
			FROM app_leave_applications
			JOIN app_employees_staff_supervision
			WHERE app_leave_applications.staff_id = app_employees_staff_supervision.subordinate_id
			AND app_employees_staff_supervision.supervisor_id = ?
			AND app_leave_applications.request_status = 'Completed'
            AND app_leave_applications.approval_status = 'Approved'
            AND app_leave_applications.leave_status = 'Inactive'
            AND app_leave_applications.return_status = 'Returning'";

        return Leave::fromQuery($query, [
            $this->staff->getKey()
        ]);
    }

}
