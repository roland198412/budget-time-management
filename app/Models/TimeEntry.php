<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeEntry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clockify_time_entry_id',
        'description',
        'clockify_user_id',
        'time_interval_start',
        'time_interval_end',
        'duration',
        'billable',
        'clockify_project_id',
        'clockify_task_id',
        'tag_ids',
        'approval_request_id',
        'type',
        'is_locked',
        'currency',
        'amount',
        'rate',
        'earned_amount',
        'earned_rate',
        'cost_amount',
        'cost_rate',
        'project_name',
        'project_color',
        'client_name',
        'clockify_client_id',
        'task_name',
        'user_name',
        'user_email',
    ];

    protected $casts = [
        'time_interval_start' => 'datetime',
        'time_interval_end' => 'datetime',
        'billable' => 'boolean',
        'is_locked' => 'boolean',
        'tag_ids' => 'array',
        'amount' => 'decimal:2',
        'rate' => 'decimal:2',
        'earned_amount' => 'decimal:2',
        'earned_rate' => 'decimal:2',
        'cost_amount' => 'decimal:2',
        'cost_rate' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'clockify_project_id', 'clockify_project_id');
    }

    public function clockifyUser(): BelongsTo
    {
        return $this->belongsTo(ClockifyUser::class, 'clockify_user_id', 'clockify_user_id');
    }
}
