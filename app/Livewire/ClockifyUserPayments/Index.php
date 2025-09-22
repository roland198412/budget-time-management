<?php

namespace App\Livewire\ClockifyUserPayments;

use App\Models\ClockifyUserPayment;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public function delete(int $id): void
    {
        ClockifyUserPayment::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.clockify-user-payments.index', ['payments' => ClockifyUserPayment::with(['projects', 'clockifyUser'])->paginate(15)]);
    }
}
