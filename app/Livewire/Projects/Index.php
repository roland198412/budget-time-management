<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public function delete(int $id): void
    {
        Project::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.projects.index', ['projects' => Project::with('client')->paginate(15)]);
    }
}