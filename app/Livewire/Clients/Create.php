<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required|string')]
    public string $clockify_client_id = '';

    #[Validate('required|string')]
    public string $clockify_workspace_id = '';

    public function save(): void
    {
        $data = $this->validate();

        Client::create($data);

        $this->redirectRoute('clients.index');
    }

    public function render()
    {
        return view('livewire.clients.create');
    }
}
