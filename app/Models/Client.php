<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\HasMany,
    SoftDeletes};

class Client extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $fillable = [
        'name',
        'clockify_client_id',
        'clockify_workspace_id',
    ];

    public function getTotalBucketDurationAttribute(): int
    {
        return $this->projects()->bucket()
            ->withSum('timeEntries', 'duration')
            ->get()
            ->sum('time_entries_sum_duration');
    }

    public function getTotalDurationHoursAttribute(): string
    {
        $hours = $this->total_duration / 3600;

        return number_format($hours, 2, ',', '');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }
}
