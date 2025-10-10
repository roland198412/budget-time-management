<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\{
    Builder,
    Model,
    Relations\BelongsTo,
    SoftDeletes};

class Bucket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sequence',
        'hours',
        'cost_per_hour',
        'bucket_start_date',
        'identifier',
        'client_id',
        'payment_status',
        'payment_date', // Add payment_date to fillable
    ];

    protected $casts = [
        'payment_status' => PaymentStatus::class, // Cast payment_status to enum
        'payment_date' => 'date', // Cast payment_date as date
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('sequenceOrdering', function (Builder $builder) {
            $builder->orderBy('sequence')
                ->orderBy('created_at')
                ->orderBy('client_id');
        });
    }

    public function getTotalDurationAttribute(): float
    {
        return ($this->client->projects()->bucket()
            ->withSum('timeEntries', 'duration')
            ->get()
            ->sum('time_entries_sum_duration')) / 3600;
    }

    public function getBucketRemainingHoursAttribute(): string
    {
        return number_format(
            $this->hours - ($this->total_duration),
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
