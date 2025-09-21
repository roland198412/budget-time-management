<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class ClockifyUser extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clockify_user_id',
        'name',
        'email',
    ];
}
