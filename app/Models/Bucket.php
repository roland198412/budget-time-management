<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Model,
    Relations\HasOne,
    SoftDeletes};
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
        'client_id'
    ];

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
