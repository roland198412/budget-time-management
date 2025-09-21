<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClockifyUserPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
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

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'clockify_user_payment_project');
    }
}
