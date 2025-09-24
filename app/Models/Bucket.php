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
        'hours',
        'cost_per_hour',
        'bucket_start_date',
        'identifier',
        'client_id'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
