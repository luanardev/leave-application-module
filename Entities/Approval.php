<?php

namespace Lumis\LeaveApplication\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lumis\StaffManagement\Entities\Staff;

/**
 * @property mixed $id
 * @property mixed $leave_id
 * @property mixed $stage_id
 * @property mixed $approver_id
 * @property mixed $decision
 * @property mixed $comment
 * @property Leave $leave
 * @property Staff $approver
 * @property Stage $stage
 */
class Approval extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_leave_approvals';

    /**
     * The primary key associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['leave_id', 'stage_id', 'approver_id', 'decision', 'comment'];

    /**
     * @return BelongsTo
     */
    public function leave(): BelongsTo
    {
        return $this->belongsTo(Leave::class, 'leave_id');
    }

    /**
     * @return BelongsTo
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    /**
     * @return BelongsTo
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'approver_id');
    }

    /**
     * @return void
     */
    public function approve(): void
    {
        $this->setAttribute('decision', 'Accepted');
    }

    /**
     * @return void
     */
    public function reject(): void
    {
        $this->setAttribute('decision', 'Rejected');
    }

    /**
     * @param $options
     * @return void
     */
    public function save($options = []): void
    {
        if (parent::save()) {
            $this->leave->process($this);
        }
    }

    /**
     * @return Staff|null
     */
    public function nextApprover(): null|Staff
    {
        $nextStage = $this->nextStage();
        $approvers = Approver::getApprovers($nextStage, $this->leave->campus);
        $nextApprover = null;
        foreach ($approvers as $approver) {
            if ($approver instanceof Approver && $approver->canApprove($this->leave, $nextStage)) {
                $nextApprover = $approver->staff;
                break;
            }
        }
        return $nextApprover;
    }

    /**
     * @return null|Stage
     */
    public function nextStage(): null|Stage
    {
        $currentLevel = $this->stage->level;
        return Stage::where('level', '>', $currentLevel)->first();
    }

    /**
     * Status
     *
     * @return string
     */
    public function decisionBadge(): string
    {
        if ($this->isAccepted()) {
            return "<span class='badge badge-success py-1 text-white'>Accepted</span>";
        }
        if ($this->isRejected()) {
            return "<span class='badge badge-danger py-1 text-white'>Rejected</span>";
        }

    }

    /**
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->decision === "Accepted";
    }

    /**
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->decision === "Rejected";
    }
}
