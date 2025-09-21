<?php

namespace App\Livewire\ClockifyUsers;

use App\Models\ClockifyUser;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public function delete(int $id): void
    {
        ClockifyUser::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.clockify-users.index', ['clockifyUsers' => ClockifyUser::paginate(15)]);
    }
}
