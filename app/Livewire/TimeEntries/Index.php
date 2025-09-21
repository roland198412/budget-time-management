<?php

namespace App\Livewire\TimeEntries;

use App\Models\{TimeEntry, Project};
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'time_interval_start';
    public $sortDirection = 'desc';
    public $dateFrom = '';
    public $dateTo = '';
    public $selectedProjects = [];
    public $selectedUsers = [];

    protected $queryString = ['search', 'sortBy', 'sortDirection', 'dateFrom', 'dateTo', 'selectedProjects', 'selectedUsers'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function updatedSelectedProjects()
    {
        $this->resetPage();
    }

    public function updatedSelectedUsers()
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
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('time_interval_start', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('time_interval_start', '<=', $this->dateTo);
            })
            ->when(!empty($this->selectedProjects), function ($query) {
                $query->whereIn('clockify_project_id', $this->selectedProjects);
            })
            ->when(!empty($this->selectedUsers), function ($query) {
                $query->whereIn('clockify_user_id', $this->selectedUsers);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        // Get all projects for the filter dropdown
        $projects = Project::orderBy('name')->get();

        // Calculate project totals from current filtered results
        $projectTotals = TimeEntry::query()
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('user_name', 'like', '%' . $this->search . '%')
                    ->orWhere('project_name', 'like', '%' . $this->search . '%')
                    ->orWhere('task_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('time_interval_start', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('time_interval_start', '<=', $this->dateTo);
            })
            ->when(!empty($this->selectedProjects), function ($query) {
                $query->whereIn('clockify_project_id', $this->selectedProjects);
            })
            ->when(!empty($this->selectedUsers), function ($query) {
                $query->whereIn('clockify_user_id', $this->selectedUsers);
            })
            ->selectRaw('project_name, project_color, SUM(duration) as total_duration')
            ->groupBy('project_name', 'project_color')
            ->get()
            ->map(function ($item) {
                $hours = $item->total_duration / 3600;
                $item->total_hours_decimal = number_format($hours, 2, ',', '');
                return $item;
            });

        // Get all users for the filter dropdown
        $users = TimeEntry::select('clockify_user_id', 'user_name')
            ->whereNotNull('user_name')
            ->distinct()
            ->orderBy('user_name')
            ->get();

        return view('livewire.time-entries.index', compact('timeEntries', 'projects', 'projectTotals', 'users'));
    }
}
