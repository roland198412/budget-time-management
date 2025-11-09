<?php

namespace App\Livewire\ClockifyUserPayments;

use App\Enums\{PaymentStatus, PaymentType};
use App\Models\{ClockifyUser, ClockifyUserPayment, Project};
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|string')]
    public $clockify_user_id = '';

    #[Validate('required|numeric|min:0')]
    public $amount_ex_vat = '';

    #[Validate('required|numeric|min:0')]
    public $vat_amount = '';

    #[Validate('nullable|numeric|min:0')]
    public $partial_payment = '';

    #[Validate('required|date')]
    public $payment_date = '';

    #[Validate('required')]
    public $payment_type = '';

    #[Validate('required')]
    public $payment_status = '';

    #[Validate('array')]
    public array $selectedProjects = [];

    public function mount(): void
    {
        $this->payment_status = PaymentStatus::PAID->value;
    }

    public function getBalanceDueProperty(): float
    {
        $amount = is_numeric($this->amount_ex_vat) ? (float) $this->amount_ex_vat : 0;
        $partial = is_numeric($this->partial_payment) ? (float) $this->partial_payment : 0;
        return max($amount - $partial, 0);
    }

    public function save(): void
    {
        $data = $this->validate();

        // Remove selectedProjects from data as it's not a model field
        $selectedProjects = $data['selectedProjects'];
        unset($data['selectedProjects']);

        $payment = ClockifyUserPayment::create($data);

        // Attach selected projects
        if (!empty($selectedProjects)) {
            $payment->projects()->attach($selectedProjects);
        }

        $this->redirectRoute('clockify-user-payments.index');
    }

    public function render()
    {
        return view('livewire.clockify-user-payments.create', [
            'users' => ClockifyUser::orderBy('name')->get(),
            'projects' => Project::orderBy('name')->get(),
            'paymentTypes' => PaymentType::cases(),
            'paymentStatuses' => PaymentStatus::cases(),
        ]);
    }
}
