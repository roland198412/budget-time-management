<?php

namespace App\Models;

use App\Enums\ProjectType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\{
    Attributes\Scope,
    Builder,
    Model,
    SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'color',
        'clockify_project_id',
        'client_id',
        'project_type',
        'budget',
        'cost_per_hour',
    ];

    protected $casts = [
        'project_type' => ProjectType::class,
        'cost_per_hour' => 'float',
    ];

    protected function remainingBudget(): Attribute
    {
        return Attribute::make(
            get: fn () => $this?->budget - (($this->timeEntries()->sum('duration') / 3600) * $this->cost_per_hour)
        );
    }

    protected function usedHours(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format(
                ($this->timeEntries()->sum('duration') / 3600),
                2,
                ',',
                ''
            ),
        );
    }

    protected function totalHours(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->budget)) {
                    return 0;
                }

                return floor($this->budget / $this->cost_per_hour);
            }
        );
    }

    protected function availableHours(): Attribute
    {
        return Attribute::make(
            get: function () {
                $duration = $this->timeEntries()->sum('duration');

                if (empty($duration)) {
                    return $this->total_hours;
                }

                return number_format(
                    ($this->total_hours - ($this->timeEntries()->sum('duration') / 3600)),
                    2,
                    ',',
                    ''
                );

            }
        );
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function buckets(): BelongsToMany
    {
        return $this->belongsToMany(Bucket::class);
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class, 'clockify_project_id', 'clockify_project_id');
    }

    public function clockifyUserPayments(): BelongsToMany
    {
        return $this->belongsToMany(ClockifyUserPayment::class, 'clockify_user_payment_project');
    }

    /**
     * To only return projects where the project type is bucket
     */
    #[Scope]
    protected function bucket(Builder $query): void
    {
        $query->where('project_type', ProjectType::BUCKET->value);
    }
}
