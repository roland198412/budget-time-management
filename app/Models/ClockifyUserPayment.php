<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class ClockifyUserPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clockify_user_id',
        'amount_ex_vat',
        'vat_amount',
        'payment_date',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
        ];
    }

    public function clockifyUser(): BelongsTo
    {
        return $this->belongsTo(ClockifyUser::class, 'clockify_user_id', 'clockify_user_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'clockify_user_payment_project');
    }
}
