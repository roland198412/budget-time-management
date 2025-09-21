<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClockifyUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clockify_user_id',
        'name',
        'email',
    ];

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class, 'clockify_user_id', 'clockify_user_id');
    }
}
