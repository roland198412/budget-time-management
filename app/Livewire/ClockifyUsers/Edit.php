<?php

namespace App\Livewire\ClockifyUsers;

use App\Models\ClockifyUsers;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('nullable|string')]
    public string $clockify_user_id = '';

    public ClockifyUsers $clockifyUser;

    public function mount(ClockifyUsers $clockifyUser): void
    {
        $this->clockifyUser = $clockifyUser;
        $this->name = $clockifyUser->name;
        $this->email = $clockifyUser->email;
        $this->clockify_user_id = $clockifyUser->clockify_user_id ?? '';
    }

    public function save(): void
    {
        $data = $this->validate();
        
        // Convert empty strings to null for nullable fields
        $data['clockify_user_id'] = $data['clockify_user_id'] ?: null;

        $this->clockifyUser->update($data);

        $this->redirectRoute('clockify-users.index');
    }

    public function render()
    {
        return view('livewire.clockify-users.edit');
    }
}