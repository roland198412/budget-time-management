<?php

namespace App\Livewire\TimeEntries;

use App\Models\TimeEntry;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'time_interval_start';
    public $sortDirection = 'desc';

    protected $queryString = ['search', 'sortBy', 'sortDirection'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        $timeEntry = TimeEntry::findOrFail($id);
        $timeEntry->delete();
        
        session()->flash('message', 'Time entry deleted successfully.');
    }

    public function render()
    {
        $timeEntries = TimeEntry::query()
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('user_name', 'like', '%' . $this->search . '%')
                    ->orWhere('project_name', 'like', '%' . $this->search . '%')
                    ->orWhere('task_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        return view('livewire.time-entries.index', compact('timeEntries'));
    }
}
