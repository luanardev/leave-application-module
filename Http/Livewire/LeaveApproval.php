<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\LeaveApplication\Entities\Approval;
use Lumis\LeaveApplication\Entities\Leave;

class LeaveApproval extends LivewireUI
{
    /**
     * @var Leave
     */
    public Leave $leave;

    /**
     * @var Staff
     */
    public Staff $approver;

    /**
     * @var Approval
     */
    public Approval $approval;

    public function __construct()
    {
        parent::__construct();
        $this->approval = new Approval();
    }

    /**
     * @param Leave $leave
     * @param Staff $approver
     * @return void
     */
    public function mount(Leave $leave, Staff $approver): void
    {
        $this->leave = $leave;
        $this->approver = $approver;

    }

    public function approve()
    {
        $this->validate();
        $this->approval->leave()->associate($this->leave);
        $this->approval->stage()->associate($this->leave->stage);
        $this->approval->approver()->associate($this->approver);
        $this->approval->approve();
        $this->approval->save();

        $this->alertSuccess('Leave application approved');
        $this->redirect(route('leave_application.home'));
    }

    public function reject()
    {
        $this->validate();
        $this->approval->leave()->associate($this->leave);
        $this->approval->stage()->associate($this->leave->stage);
        $this->approval->approver()->associate($this->approver);
        $this->approval->reject();
        $this->approval->save();

        $this->alertError('Leave application rejected');
        $this->redirect(route('leave_application.home'));
    }

    public function rules(): array
    {
        return [
            'approval.comment' => 'required|string',
        ];
    }

    public function render()
    {
        return view('leaveapplication::livewire.leave-approval');
    }
}
