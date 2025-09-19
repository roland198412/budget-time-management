<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
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
}
