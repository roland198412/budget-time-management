<?php

namespace App\Models;

use App\Enums\ProjectType;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
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
    ];

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
}
