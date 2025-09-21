<?php

namespace App\Livewire\ClockifyUserPayments;

use App\Models\{ClockifyUser, ClockifyUserPayment, Project};
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public ClockifyUserPayment $payment;

    #[Validate('required|string')]
    public $clockify_user_id = '';

    #[Validate('required|numeric|min:0')]
    public $amount_ex_vat = '';

    #[Validate('required|numeric|min:0')]
    public $vat_amount = '';

    #[Validate('required|date')]
    public $payment_date = '';

    #[Validate('array')]
    public array $selectedProjects = [];

    public function mount(ClockifyUserPayment $payment): void
    {
        $this->payment = $payment;
        $this->clockify_user_id = $payment->clockify_user_id;
        $this->amount_ex_vat = $payment->amount_ex_vat;
        $this->vat_amount = $payment->vat_amount;
        $this->payment_date = $payment->payment_date->format('Y-m-d');
        $this->selectedProjects = $payment->projects->pluck('id')->toArray();
    }

    public function save(): void
    {
        $data = $this->validate();

        // Remove selectedProjects from data as it's not a model field
        $selectedProjects = $data['selectedProjects'];
        unset($data['selectedProjects']);

        $this->payment->update($data);

        // Sync selected projects
        $this->payment->projects()->sync($selectedProjects);

        $this->redirectRoute('clockify-user-payments.index');
    }

    public function render()
    {
        return view('livewire.clockify-user-payments.edit', [
            'users' => ClockifyUser::orderBy('name')->get(),
            'projects' => Project::orderBy('name')->get()
        ]);
    }
}
