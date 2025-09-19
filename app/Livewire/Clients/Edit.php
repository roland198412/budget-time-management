<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    #[Validate('required|string|min:3')]
    public string $name = '';

    public Client $client;

    public function mount(Client $client): void
    {
        $this->client = $client;
        $this->name = $client->name;
    }

    public function save(): void
    {
        $data = $this->validate();

        $this->client->update($data);

        $this->redirectRoute('clients.index');
    }

    public function render()
    {
        return view('livewire.clients.edit');
    }
}
