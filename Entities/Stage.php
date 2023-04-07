<?php

namespace Lumis\LeaveApplication\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Krlove\EloquentModelGenerator\Model\HasMany;

/**
 * @property mixed $id
 * @property string $level
 * @property string $name
 * @property string $slug
 * @property string $description
 */
class Stage extends Model
{
    use HasFactory, HasUuids;

    const DEFAULT = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_leave_stages';

    /**
     * The primary key associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['level', 'name', 'slug', 'description'];

    /**
     * @return HasMany
     */
    public function leaves(): HasMany
    {
        return $this->HasMany(Leave::class, 'stage_id');
    }

    /**
     * @return HasMany
     */
    public function approvers(): HasMany
    {
        return $this->HasMany(Approver::class, 'stage_id');
    }

    /**
     * @return string
     */
    public function shortName(): string
    {
        return "Stage " . $this->level;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        $default = static::default();
        if ($default->id == $this->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return static
     */
    public static function default(): static
    {
        return Stage::where('level', static::DEFAULT)->first();
    }

    /**
     * @return bool
     */
    public function isNotLast(): bool
    {
        return !$this->isLast();
    }

    /**
     * @return bool
     */
    public function isLast(): bool
    {
        $last = static::last();
        return $this->is($last);
    }

    /**
     * Returns the last record on posts table
     *
     * @return Stage|null
     */
    public static function last(): null|Stage
    {
        return static::orderBy('level', 'DESC')->first();
    }
}
