<?php

namespace Lumis\LeaveApplication\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;
use Luanardev\LivewireUI\LivewireUI;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\Leave\Entities\AnnualStaffLeave;
use Lumis\LeaveApplication\Entities\Leave;
use Lumis\LeaveApplication\Entities\LeaveType;
use Lumis\LeaveApplication\Entities\StaffLeave;
use Lumis\LeaveApplication\Entities\Stage;
use Lumis\Organization\Entities\FinancialYear;

class LeaveForm extends LivewireUI
{
    use WithFileUploads;

    const DATEFORMAT = 'Y-m-d';

    /**
     * @var Staff
     */
    public Staff $staff;

    /**
     * @var LeaveType
     */
    public LeaveType $leaveType;

    /**
     * @var FinancialYear
     */
    public FinancialYear $financialYear;

    /**
     * @var Leave
     */
    public Leave $leave;

    /**
     * @var mixed
     */
    public mixed $daysAllowed;

    /**
     * @var mixed
     */
    public mixed $document;

    /**
     * @var bool
     */

    public function __construct()
    {
        parent::__construct();
        $this->document = null;
        $this->daysAllowed = null;
        $this->leave = new Leave();
    }

    public function mount(Staff $staff, FinancialYear $financialYear, LeaveType $leaveType): void
    {
        $this->staff = $staff;
        $this->financialYear = $financialYear;
        $this->leaveType = $leaveType;

        $staffLeave = new StaffLeave($staff, $financialYear, $leaveType);

        $this->daysAllowed = $staffLeave->daysAllowed();

        if ($staffLeave->hasLeaveDraft()) {
            $this->leave = $staffLeave->getLeaveDraft();
        }
    }

    public function saveDraft()
    {
        $this->process();
        $this->leave->draft();
        $this->leave->save();
        $this->alert('Leave draft saved');
        $this->redirect(route('leave_application.home'));
    }

    /**
     * @return void
     */
    private function process(): void
    {
        $this->validate();
        $document = $this->uploadDocument();
        $this->leave->document = $document;
        $this->leave->financialYear()->associate($this->financialYear);
        $this->leave->leaveType()->associate($this->leaveType);
        $this->leave->staff()->associate($this->staff);
        $this->leave->campus()->associate($this->staff->employment->campus);
        $this->leave->stage()->associate(Stage::default());
        $this->leave->makeEndDate();
    }

    private function uploadDocument()
    {
        $this->validate([
            'document' => 'nullable|mimes:jpg,png,jpeg,doc,docx,pdf|max:20480',
        ]);

        if (!empty($this->document)) {
            return $this->document->storePublicly("leaves/{$this->leaveType->slug}", 'public');
        } else {
            return null;
        }

    }

    public function saveFinal()
    {
        $this->process();
        $this->leave->processing();
        $this->leave->save();
        $this->alert('Leave application successful');
        $this->redirect(route('leave_application.home'));
    }

    public function rules(): array
    {
        return [
            'leave.period' => 'required|numeric|lte:' . $this->daysAllowed,
            'leave.start_date' => 'required|date|date_format:' . static::DATEFORMAT,
            'leave.delegation' => 'required|string',
            'leave.summary' => 'nullable|string'
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('leaveapplication::livewire.leave-form');
    }


}

