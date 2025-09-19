<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required|string')]
    public string $clockify_client_id = '';

    #[Validate('required|string')]
    public string $clockify_workspace_id = '';

    public Client $client;

    public function mount(Client $client): void
    {
        $this->client = $client;
        $this->name = $client->name;
        $this->clockify_client_id = $client->clockify_client_id;
        $this->clockify_workspace_id = $client->clockify_workspace_id;
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
