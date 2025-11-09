<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\HasMany,
    SoftDeletes};

class Client extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $fillable = [
        'name',
        'cost_per_hour',
        'clockify_client_id',
        'clockify_workspace_id',
    ];

    protected $casts = [
        'cost_per_hour' => 'float',
    ];

    public function getTotalBucketDurationAttribute(): int
    {
        return $this->projects()->bucket()
            ->withSum('timeEntries', 'duration')
            ->get()
            ->sum('time_entries_sum_duration');
    }

    public function getTotalDurationHoursAttribute(): string
    {
        $hours = $this->total_duration / 3600;

        return number_format($hours, 2, ',', '');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(ClientContact::class, 'client_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function buckets(): HasMany
    {
        return $this->hasMany(Bucket::class, 'client_id');
    }

    public function getTotalBudgetAttribute(): float
    {
        return $this->buckets()->where('payment_status', PaymentStatus::PAID)->sum('hours') * $this->cost_per_hour;
    }

    public function getTotalPaidAttribute(): float
    {
        // Get all payments related to this client's bucket projects
        $payments = $this->projects()
            ->bucket()
            ->join('clockify_user_payment_project', 'projects.id', '=', 'clockify_user_payment_project.project_id')
            ->join('clockify_user_payments', 'clockify_user_payment_project.clockify_user_payment_id', '=', 'clockify_user_payments.id')
            ->select('clockify_user_payments.id', 'clockify_user_payments.amount_ex_vat', 'clockify_user_payments.partial_payment', 'clockify_user_payments.payment_status')
            ->distinct()
            ->get();

        $totalPaid = $payments->sum(function ($payment) {
            // If status is PAID, include full amount + any partial payment
            if ($payment->payment_status === PaymentStatus::PAID->value) {
                return $payment->amount_ex_vat + ($payment->partial_payment ?? 0);
            }
            // If status is UNPAID, only include the partial payment (money already paid)
            return $payment->partial_payment ?? 0;
        });

        return $totalPaid ?? 0;
    }

    public function getTotalAmountOutstandingToDevelopersAttribute(): float
    {
        $totalOutstanding = $this->projects()
            ->bucket()
            ->join('clockify_user_payment_project', 'projects.id', '=', 'clockify_user_payment_project.project_id')
            ->join('clockify_user_payments', 'clockify_user_payment_project.clockify_user_payment_id', '=', 'clockify_user_payments.id')
            ->select('clockify_user_payments.id', 'clockify_user_payments.amount_ex_vat', 'clockify_user_payments.partial_payment')
            ->where('clockify_user_payments.payment_status', PaymentStatus::UNPAID)
            ->distinct()
            ->get()
            ->sum(function ($payment) {
                return ($payment->amount_ex_vat - ($payment->partial_payment ?? 0));
            });

        return max($totalOutstanding ?? 0, 0);
    }
}
