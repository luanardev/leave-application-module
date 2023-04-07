<?php

namespace Lumis\LeaveApplication\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property mixed $id
 * @property string $name
 * @property string $slug
 * @property integer $period
 * @property string $unit
 */
class LeaveType extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_leave_types';

    /**
     * The primary key associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'period', 'unit'];

    /**
     * @param $name
     * @return null|LeaveType
     */
    public static function getByName($name): ?LeaveType
    {
        $name = Str::lower($name);
        return static::where('name', $name)->first();
    }

    /**
     * @param $unit
     * @return null|Collection
     */
    public static function getByUnit($unit): ?Collection
    {
        $unit = Str::upper($unit);
        return static::where('unit', $unit)->get();
    }

    /**
     * @return null|Collection
     */
    public static function getByDaysUnit(): ?Collection
    {
        return static::where('unit', 'DAYS')->get();
    }

    /**
     * @return null|Collection
     */
    public static function getByMonthsUnit(): ?Collection
    {
        return static::where('unit', 'MONTHS')->get();
    }

    /**
     * @return null|Collection
     */
    public static function getByYearsUnit(): ?Collection
    {
        return static::where('unit', 'YEARS')->get();
    }

    /**
     * @return HasMany
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class, 'type_id');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * @return string
     */
    public function getPeriodString(): string
    {
        if ($this->getPeriod() > 1) {
            $unit = Str::plural($this->getUnit());
        } else {
            $unit = Str::singular($this->getUnit());
        }
        return $this->getPeriod() . " " . $unit;
    }

    /**
     * @return int
     */
    public function getPeriod(): int
    {
        return $this->getAttribute('period');
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return ucfirst(strtolower($this->getAttribute('unit')));
    }

    /**
     * @return bool
     */
    public function isAnnualLeave(): bool
    {
        return $this->getSlug() == 'annual_leave';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->getAttribute('slug');
    }

    /**
     * @return bool
     */
    public function isStudyLeave(): bool
    {
        return $this->getSlug() == 'study_leave';
    }

    /**
     * @return bool
     */
    public function isSabbaticalLeave(): bool
    {
        return $this->getSlug() == 'sabbatical_leave';
    }

    /**
     * @return bool
     */
    public function isAbsenceLeave(): bool
    {
        return $this->getSlug() == 'leave_of_absence';
    }

    /**
     * @return bool
     */
    public function isDaysUnit(): bool
    {
        return strtoupper($this->getUnit()) == 'DAYS';
    }

    /**
     * @return bool
     */
    public function isMonthsUnit(): bool
    {
        return strtoupper($this->getUnit()) == 'MONTHS';
    }

    /**
     * @return bool
     */
    public function isYearsUnit(): bool
    {
        return strtoupper($this->getUnit()) == 'YEARS';
    }
}
