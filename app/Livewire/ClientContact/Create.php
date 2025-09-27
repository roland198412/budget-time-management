<?php

namespace App\Livewire\ClientContact;

use App\Models\{Client, ClientContact};
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|string|min:2')]
    public string $firstname = '';

    #[Validate('required|string|min:2')]
    public string $lastname = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|exists:clients,id')]
    public string $client_id = '';

    public function save(): void
    {
        $data = $this->validate();

        ClientContact::create($data);

        $this->redirectRoute('client-contacts.index');
    }

    public function render()
    {
        return view('livewire.client-contact.create', ['clients' => Client::all()]);
    }
}
