<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bucket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hours',
        'cost_per_hour',
        'bucket_start_date',
        'amount',
        'identifier',
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
