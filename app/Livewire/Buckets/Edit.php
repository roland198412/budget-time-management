<?php

namespace App\Livewire\Buckets;

use App\Models\{Bucket, Client};
use App\Enums\PaymentStatus;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    #[Validate('required|string|min:3')]
    public string $identifier = '';

    #[Validate('required|date')]
    public $bucket_start_date = '';

    #[Validate('nullable|numeric|min:0')]
    public int $cost_per_hour = 0;

    #[Validate('nullable|numeric|min:0')]
    public int $hours = 0;

    #[Validate('required|numeric|min:1')]
    public int $sequence = 0;

    #[Validate('required|exists:clients,id')]
    public string $client_id = '';

    #[Validate('required|in:paid,unpaid')]
    public string $payment_status = 'unpaid';

    #[Validate('nullable|date')]
    public $payment_date = null;

    public Bucket $bucket;

    public function mount(Bucket $bucket): void
    {
        $this->bucket = $bucket;
        $this->identifier = $bucket->identifier;
        $this->bucket_start_date = $bucket->bucket_start_date;
        $this->cost_per_hour = $bucket->cost_per_hour;
        $this->hours = $bucket->hours;
        $this->sequence = $bucket->sequence;
        $this->client_id = $bucket->client_id;
        $this->payment_status = $bucket->payment_status?->value ?? 'unpaid';
        $this->payment_date = $bucket->payment_date?->format('Y-m-d');
    }

    public function save(): void
    {
        $data = $this->validate();

        $this->bucket->update($data);

        $this->redirectRoute('buckets.index');
    }

    public function render()
    {
        return view('livewire.buckets.edit', [
            'clients' => Client::all(),
            'paymentStatuses' => PaymentStatus::cases(),
        ]);
    }
}
