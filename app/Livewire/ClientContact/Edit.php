<?php

namespace App\Livewire\ClientContact;

use App\Models\{Client, ClientContact};
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    #[Validate('required|numeric|min:1')]
    public int $sequence = 0;

    #[Validate('required|string|min:2')]
    public string $firstname = '';

    #[Validate('required|string|min:2')]
    public string $lastname = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|exists:clients,id')]
    public string $client_id = '';

    public ClientContact $clientContact;

    public function mount(ClientContact $clientContact): void
    {
        $this->clientContact = $clientContact;
        $this->sequence = $clientContact->sequence;
        $this->firstname = $clientContact->firstname;
        $this->lastname = $clientContact->lastname;
        $this->email = $clientContact->email;
        $this->client_id = $clientContact->client_id;
    }

    public function save(): void
    {
        $data = $this->validate();

        $this->clientContact->update($data);

        $this->redirectRoute('client-contacts.index');
    }

    public function render()
    {
        return view('livewire.client-contact.edit', ['clients' => Client::all()]);
    }
}
