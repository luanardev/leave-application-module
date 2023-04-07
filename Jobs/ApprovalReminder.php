<?php

namespace Lumis\LeaveApplication\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\Approver;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Notifications\LeaveApprovalNotification;
use Lumis\Organization\Entities\FinancialYear;

class ApprovalReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $financialYear = FinancialYear::getCurrentName();
        $leaves = Leave::pendingApproval($financialYear);
        foreach ($leaves as $leave) {
            // if leave's current stage is not approved and leave is past
            if ($leave instanceof Leave && !$leave->hasStageApproved() && Carbon::parse($leave->created_at)->isPast()) {
                if ($leave->stage->isDefault()) {
                    $approver = $leave->staff->supervisor;
                } else {
                    $approver = $this->getApprover($leave);
                }
                if(!empty($approver)){
                    $notification = new LeaveApprovalNotification($leave, $approver);
                    Notification::send($approver, $notification);
                }
            }
        }
    }

    /**
     * @param Leave $leave
     * @return Staff|null
     */
    public function getApprover(Leave $leave): null|Staff
    {
        $approvers = Approver::getApprovers($leave->stage, $leave->campus);
        $currentApprover = null;
        foreach ($approvers as $approver) {
            if ($approver instanceof Approver && $approver->canApprove($leave, $leave->stage)) {
                $currentApprover = $approver->staff;
                break;
            }
        }
        return $currentApprover;
    }
}
