<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];
}
