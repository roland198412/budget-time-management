<?php

namespace App\Livewire\Projects;

use App\Models\{Client, Project};
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
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

    public Project $project;

    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->name = $project->name;
        $this->project_type = $project->project_type ? $project->project_type->value : '';
        $this->client_id = (string) $project->client_id;
        $this->color = $project->color ?? '';
        $this->clockify_project_id = $project->clockify_project_id ?? '';
        $this->budget = $project->budget ? (string) $project->budget : '';
        $this->cost_per_hour = $project->cost_per_hour ? (string) $project->cost_per_hour : '';
    }

    public function save(): void
    {
        $data = $this->validate();

        // Convert empty strings to null for nullable fields
        $data['color'] = $data['color'] ?: null;
        $data['clockify_project_id'] = $data['clockify_project_id'] ?: null;
        $data['budget'] = $data['budget'] ?: null;
        $data['cost_per_hour'] = $data['cost_per_hour'] ?: null;

        $this->project->update($data);

        $this->redirectRoute('projects.index');
    }

    public function render()
    {
        return view('livewire.projects.edit', [
            'clients' => Client::all()
        ]);
    }
}
