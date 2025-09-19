<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'clockify_project_id',
        'client_id',
        'project_type',
        'budget',
        'cost_per_hour',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
