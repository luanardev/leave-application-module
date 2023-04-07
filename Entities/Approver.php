<?php

namespace Lumis\LeaveApplication\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lumis\StaffManagement\Entities\Staff;
use Lumis\Organization\Entities\Campus;

/**
 * @property mixed $id
 * @property mixed $stage_id
 * @property mixed $staff_id
 * @property mixed $campus_id
 * @property Stage $stage
 * @property Staff $staff
 * @property Campus $campus
 */
class Approver extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_leave_approvers';

    /**
     * The primary key associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['stage_id', 'staff_id', 'campus_id'];

    /**
     * @param Stage $stage
     * @return Staff|null
     */
    public static function getApprover(Stage $stage): Staff|null
    {
        $approver = static::where('stage_id', $stage->id)->first();
        if (isset($approver) && $approver instanceof Approver) {
            return $approver->staff;
        }
    }

    /**
     * @param Stage $stage
     * @param Campus $campus
     * @return Collection
     */
    public static function getApprovers(Stage $stage, Campus $campus): Collection
    {
        return static::where('stage_id', $stage->id)
            ->where('campus_id', $campus->id)
            ->get();
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
     * @param Leave $leave
     * @param Stage $stage
     * @return bool
     */
    public function canApprove(Leave $leave, Stage $stage): bool
    {
        if ($this->hasCampus($leave->campus)
            && $this->isStageApprover($stage)
            && !$this->isApplicantOf($leave)
            && !$this->hasApproved($leave)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Campus $campus
     * @return bool
     */
    public function hasCampus(Campus $campus): bool
    {
        if ($this->campus_id == $campus->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Stage $stage
     * @return bool
     */
    public function isStageApprover(Stage $stage): bool
    {
        if ($this->stage_id == $stage->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Leave $leave
     * @return bool
     */
    public function isApplicantOf(Leave $leave): bool
    {
        if ($this->staff_id == $leave->staff_id) {
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
        $exists = $leave->approvals()->where('approver_id', $this->staff_id)->exists();
        return (bool)$exists;
    }
}
