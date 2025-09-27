<?php

namespace App\Livewire\ClientContact;

use App\Models\{ClientContact};
use Livewire\Component;

class Index extends Component
{
    public function delete(int $id): void
    {
        ClientContact::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.client-contact.index', ['clientContacts' => ClientContact::paginate(15)]);
    }
}
