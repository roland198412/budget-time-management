<?php

namespace App\Livewire\ClockifyUsers;

use App\Models\ClockifyUsers;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public function delete(int $id): void
    {
        ClockifyUsers::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.clockify-users.index', ['clockifyUsers' => ClockifyUsers::paginate(15)]);
    }
}