<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    Relations\BelongsTo,
    SoftDeletes
};

class Bucket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sequence',
        'hours',
        'cost_per_hour',
        'bucket_start_date',
        'identifier',
        'client_id'
    ];

    public function getBucketRemainingHoursAttribute(): string
    {
        $duration = $this->client->projects()->bucket()
            ->withSum('timeEntries', 'duration')
            ->get()
            ->sum('time_entries_sum_duration');

        return number_format(
            $this->hours - ($duration / 3600),
            2,
            ',',
            ''
        );
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
