<?php

namespace App\Livewire\Buckets;

use App\Models\{Bucket, Client, Project};
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|string|min:3')]
    public string $identifier = '';

    #[Validate('required|date')]
    public $bucket_start_date = '';

    #[Validate('nullable|numeric|min:0')]
    public int $cost_per_hour = 0;

    #[Validate('nullable|numeric|min:0')]
    public int $hours = 0;

    #[Validate('required|exists:clients,id')]
    public string $client_id = '';

    #[Validate('array')]
    public array $project_ids = []; // multiselect

    public array $projects = [];

    public function updatedClientId($value)
    {
        $this->projects = Project::where('client_id', $value)->get()->toArray();
        $this->project_ids = [];
    }

    public function save(): void
    {
        $data = $this->validate();

        $bucket = Bucket::create($data);

        if (!empty($this->project_ids)) {
            $bucket->projects()->attach($this->project_ids);
        }

        $this->redirectRoute('buckets.index');
    }

    public function render()
    {
        return view('livewire.buckets.create', ['clients' => Client::all(),  'projects' => $this->projects]);
    }
}
