<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public function delete(int $id): void
    {
        Client::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.clients.index', ['clients' => Client::paginate(15)]);
    }
}
