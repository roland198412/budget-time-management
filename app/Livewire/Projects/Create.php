<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\Client;
use App\Enums\ProjectType;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required')]
    public string $project_type = '';

    #[Validate('required|exists:clients,id')]
    public string $client_id = '';

    #[Validate('nullable|string')]
    public string $color = '';

    #[Validate('nullable|string')]
    public string $clockify_project_id = '';

    #[Validate('nullable|numeric|min:0')]
    public string $budget = '';

    #[Validate('nullable|numeric|min:0')]
    public string $cost_per_hour = '';

    public function save(): void
    {
        $data = $this->validate();
        
        // Convert empty strings to null for nullable fields
        $data['color'] = $data['color'] ?: null;
        $data['clockify_project_id'] = $data['clockify_project_id'] ?: null;
        $data['budget'] = $data['budget'] ?: null;
        $data['cost_per_hour'] = $data['cost_per_hour'] ?: null;

        Project::create($data);

        $this->redirectRoute('projects.index');
    }

    public function render()
    {
        return view('livewire.projects.create', [
            'clients' => Client::all()
        ]);
    }
}