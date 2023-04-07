<?php

namespace Lumis\LeaveApplication\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\Leave\Events\LeaveApproved;
use Lumis\Leave\Events\NextStage;
use Lumis\Organization\Entities\Campus;
use Lumis\Organization\Entities\FinancialYear;

/**
 * @property mixed $id
 * @property mixed $financial_year
 * @property mixed $staff_id
 * @property mixed $campus_id
 * @property mixed $type_id
 * @property mixed $stage_id
 * @property int $period
 * @property mixed $start_date
 * @property mixed $end_date
 * @property mixed $delegation
 * @property mixed $summary
 * @property mixed $document
 * @property mixed $request_status
 * @property mixed $approval_status
 * @property mixed $leave_status
 * @property mixed $return_status
 * @property Staff $staff
 * @property Campus $campus
 * @property LeaveType $leaveType
 * @property FinancialYear $financialYear
 * @property Stage $stage
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Leave extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_leave_applications';

    /**
     * The primary key associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'financial_year', 'staff_id', 'campus_id', 'type_id', 'stage_id', 'period', 'start_date', 'end_date',
        'delegation', 'summary', 'document', 'request_status', 'approval_status', 'leave_status', 'return_status', 'return_date'
    ];

    /**
     * @return Collection
     */
    public static function startingToday(): Collection
    {
        return Leave::where('request_status', 'Completed')
            ->where('approval_status', 'Approved')
            ->where('leave_status', 'Pending')
            ->where('start_date', today()->toDateString())
            ->get();
    }

    /**
     * @return Collection
     */
    public static function endingToday(): Collection
    {
        return Leave::where('request_status', 'Completed')
            ->where('approval_status', 'Approved')
            ->where('leave_status', 'Active')
            ->where('end_date', today()->toDateString())
            ->get();
    }

    /**
     * @return Collection
     */
    public static function notReturned(): Collection
    {
        return Leave::where('request_status', 'Completed')
            ->where('approval_status', 'Approved')
            ->where('leave_status', 'Inactive')
            ->where('return_status', 'Pending')
            ->get();
    }

    /**
     * @param mixed $financialYear
     * @return Collection
     */
    public static function pendingApproval(mixed $financialYear): Collection
    {
        return Leave::where('request_status', 'Processing')
            ->where('financial_year', $financialYear)
            ->where('approval_status', 'Pending')
            ->where('leave_status', 'Pending')
            ->get();
    }

    /**
     * @return BelongsTo
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    /**
     * @return BelongsTo
     */
    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    /**
     * @return BelongsTo
     */
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'type_id');
    }

    /**
     * @return BelongsTo
     */
    public function financialYear(): BelongsTo
    {
        return $this->belongsTo(FinancialYear::class, 'financial_year');
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->leave_status === "Active";
    }

    /**
     * @return bool
     */
    public function isInActive(): bool
    {
        return $this->leave_status === "Inactive";
    }

    /**
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->request_status === "Draft";
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->request_status === "Completed";
    }

    /**
     * @return bool
     */
    public function isReturning(): bool
    {
        return $this->return_status === "Returning";
    }

    /**
     * @return bool
     */
    public function isReturned(): bool
    {
        return $this->return_status === "Returned";
    }

    /**
     * @return bool
     */
    public function hasApprovals(): bool
    {
        return $this->approvals()->exists();
    }

    /**
     * @return HasMany
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'leave_id');
    }

    /**
     * @param Staff $staff
     * @return bool
     */
    public function isApprovedBy(Staff $staff): bool
    {
        return $this->approvals()
            ->where('approver_id', $staff->id)
            ->exists();

    }

    /**
     * @return Leave
     */
    public function cancel(): Leave
    {
        $this->setAttribute('request_status', 'Cancelled');
        return $this;

    }

    /**
     * @return Leave
     */
    public function draft(): Leave
    {
        $this->setAttribute('request_status', 'Draft');
        return $this;

    }

    /**
     * @return Leave
     */
    public function processing(): Leave
    {
        $this->setAttribute('request_status', 'Processing');
        return $this;

    }

    /**
     * @return Leave
     */
    public function confirmReturn(): Leave
    {
        $this->setAttribute('return_status', 'Returned');
        return $this;

    }

    /**
     * @return Leave
     */
    public function requestReturn(): Leave
    {
        $this->setAttribute('return_status', 'Returning');
        $this->setAttribute('return_date', today()->toDateString());
        return $this;

    }

    /**
     * @return Leave
     */
    public function deactivate(): Leave
    {
        $this->setAttribute('leave_status', 'Inactive');
        return $this;
    }

    /**
     * @return void
     */
    public function makeEndDate(): void
    {
        $holidays = Holidays::getStaticHolidays();

        if (isset($this->start_date) && $this->period > 0) {
            if ($this->leaveType->isDaysUnit()) {

                $endDate = Carbon::parse($this->start_date)->addWeekdays($this->period);

                for ($index = 1; $index <= $this->period; $index++) {
                    if (in_array(Carbon::parse($this->start_date)->addWeekdays($index)->toDateString(), $holidays)) {
                        $endDate->addDay();
                    }
                }
                $this->end_date = $endDate->toDateString();
            } elseif ($this->leaveType->isMonthsUnit()) {
                $endDate = Carbon::parse($this->start_date)->addMonths($this->period);
                $this->end_date = $endDate->toDateString();
            } elseif ($this->leaveType->isYearsUnit()) {
                $endDate = Carbon::parse($this->start_date)->addYears($this->period);
                $this->end_date = $endDate->toDateString();
            }
        }

    }

    /**
     * @param Approval $approval
     * @return void
     */
    public function process(Approval $approval): void
    {
        if ($approval->isRejected()) {
            $this->reject()->complete()->save();
            LeaveApproved::dispatch($this);
        } elseif ($approval->isAccepted()) {
            if ($this->isAtLastStage()) {
                if ($this->willStartToday()) {
                    $this->approve()->complete()->activate()->save();
                } else {
                    $this->approve()->complete()->save();
                }
                LeaveApproved::dispatch($this);
            } else {
                $nextStage = $approval->nextStage();
                $this->stage()->associate($nextStage);
                $this->save();
                NextStage::dispatch($approval);
            }
        }
    }

    /**
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->approval_status === "Rejected";
    }

    /**
     * @return Leave
     */
    public function complete(): Leave
    {
        $this->setAttribute('request_status', 'Completed');
        return $this;

    }

    /**
     * @return Leave
     */
    public function reject(): Leave
    {
        $this->setAttribute('approval_status', 'Rejected');
        return $this;
    }

    /**
     * @return bool
     */
    public function isAtLastStage(): bool
    {
        $lastStage = Stage::last();
        if ($this->stage_id == $lastStage->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function willStartToday(): bool
    {
        return $this->start_date == today()->toDateString();
    }

    /**
     * @return Leave
     */
    public function activate(): Leave
    {
        $this->setAttribute('leave_status', 'Active');
        return $this;
    }

    /**
     * @return Leave
     */
    public function approve(): Leave
    {
        $this->setAttribute('approval_status', 'Approved');
        return $this;

    }

    /**
     * @return BelongsTo
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    /**
     * @return string
     */
    public function getPeriodString(): string
    {
        if ($this->period > 1) {
            $unit = Str::plural($this->leaveType->getUnit());
        } else {
            $unit = Str::singular($this->leaveType->getUnit());
        }
        return $this->period . " " . $unit;
    }

    /**
     * start date
     *
     * @return string|null
     */
    public function startDate(): ?string
    {
        if (isset($this->start_date)) {
            return $this->start_date->format('d-M-Y');
        } else {
            return null;
        }

    }

    /**
     * end date
     *
     * @return string|null
     */
    public function endDate(): ?string
    {
        if (isset($this->end_date)) {
            return $this->end_date->format('d-M-Y');
        } else {
            return null;
        }
    }

    /**
     * end date
     *
     * @return string|null
     */
    public function appliedDate(): ?string
    {
        if (isset($this->created_at)) {
            return $this->created_at->format('d-M-Y');
        } else {
            return null;
        }
    }

    /**
     * end date
     *
     * @return string|null
     */
    public function appliedPeriod(): ?string
    {
        if (isset($this->created_at)) {
            return $this->created_at->diffForHumans();
        } else {
            return null;
        }
    }

    /**
     * end date
     *
     * @return string|null
     */
    public function updatedPeriod(): ?string
    {
        if (isset($this->updated_at)) {
            return $this->updated_at->diffForHumans();
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function hasStageApproved(): bool
    {
        return $this->isStageApproved($this->stage);
    }

    /**
     * @param Stage $stage
     * @return bool
     */
    public function isStageApproved(Stage $stage): bool
    {
        return $this->approvals()
            ->where('stage_id', $stage->id)
            ->exists();
    }

    /**
     * @return float
     */
    public function progress(): float
    {
        $allStages = Stage::count();
        $approvedStages = $this->approvals()->count();
        return ceil(100.0 * ($approvedStages / $allStages));
    }

    /**
     * Status
     *
     * @return string|null
     */
    public function statusBadge(): null|string
    {
        if ($this->isProcessing()) {
            return "<span class='badge badge-info py-1 text-white'>Processing</span>";
        } elseif ($this->isCancelled()) {
            return "<span class='badge badge-warning py-1 text-white'>Cancelled</span>";
        } elseif ($this->isApproved()) {
            return "<span class='badge badge-success py-1 text-white'>Approved</span>";
        } elseif ($this->isRejected()) {
            return "<span class='badge badge-danger py-1 text-white'>Rejected</span>";
        } else {
            return null;
        }

    }

    /**
     * Status
     *
     * @return string|null
     */
    public function returnStatusBadge(): null|string
    {
        if ($this->isReturning()) {
            return "<span class='badge badge-info py-1 text-white'>Returning</span>";
        } elseif ($this->isReturned()) {
            return "<span class='badge badge-success py-1 text-white'>Returned</span>";
        }else{
            return "<span class='badge badge-danger py-1 text-white'>Not Returned</span>";
        }

    }



    // Static methods

    /**
     * @return bool
     */
    public function isProcessing(): bool
    {
        return $this->request_status === "Processing";
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->request_status === "Cancelled";
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approval_status === "Approved";
    }

    /**
     * @return string|null
     */
    public function getMessage(): null|string
    {
        if ($this->isProcessing()) {
            return "Your {$this->leaveType->getName()} application is being processed. Please wait for the feedback.";
        } elseif ($this->isApproved()) {
            return "Your {$this->leaveType->getName()} application was approved.";
        } elseif ($this->isRejected()) {
            return "Your {$this->leaveType->getName()} application was rejected.";
        } else {
            return null;
        }
    }


}
