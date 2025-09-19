<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClockifyUsers extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clockify_user_id',
        'name',
        'email',
    ];
}
