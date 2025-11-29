<?php

namespace App\Livewire\TimeEntries;

use App\Models\{TimeEntry, Project};
use Carbon\Carbon;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'time_interval_start';
    public $sortDirection = 'desc';
    public $selectedDateFilter = 'this_week';  // Set default to this week
    public $selectedProjects = [];
    public $selectedUsers = [];

    // Custom date range properties
    public $fromDate = null;
    public $toDate = null;

    protected $queryString = ['search', 'sortBy', 'sortDirection', 'selectedDateFilter', 'selectedProjects', 'selectedUsers', 'fromDate', 'toDate'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedDateFilter()
    {
        // Clear custom range when selecting a preset
        if ($this->selectedDateFilter !== 'custom') {
            $this->fromDate = null;
            $this->toDate = null;
        }
        $this->resetPage();
    }

    public function applyCustomRange(): void
    {
        if ($this->fromDate && $this->toDate) {
            $this->selectedDateFilter = 'custom';
            $this->resetPage();
        }
    }

    public function clearCustomRange(): void
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->selectedDateFilter = 'all';
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

    protected function getDateRange(): ?array
    {
        // Handle custom date range first
        if ($this->selectedDateFilter === 'custom' && $this->fromDate && $this->toDate) {
            return [
                'start' => Carbon::parse($this->fromDate)->startOfDay(),
                'end' => Carbon::parse($this->toDate)->endOfDay(),
            ];
        }

        return match($this->selectedDateFilter) {
            'today' => [
                'start' => Carbon::today(),
                'end' => Carbon::today()->endOfDay(),
            ],
            'yesterday' => [
                'start' => Carbon::yesterday(),
                'end' => Carbon::yesterday()->endOfDay(),
            ],
            'this_week' => [
                'start' => Carbon::now()->startOfWeek(),
                'end' => Carbon::now()->endOfWeek(),
            ],
            'last_week' => [
                'start' => Carbon::now()->subWeek()->startOfWeek(),
                'end' => Carbon::now()->subWeek()->endOfWeek(),
            ],
            'this_month' => [
                'start' => Carbon::now()->startOfMonth(),
                'end' => Carbon::now()->endOfMonth(),
            ],
            'last_month' => [
                'start' => Carbon::now()->subMonth()->startOfMonth(),
                'end' => Carbon::now()->subMonth()->endOfMonth(),
            ],
            'this_quarter' => [
                'start' => Carbon::now()->startOfQuarter(),
                'end' => Carbon::now()->endOfQuarter(),
            ],
            'last_quarter' => [
                'start' => Carbon::now()->subQuarter()->startOfQuarter(),
                'end' => Carbon::now()->subQuarter()->endOfQuarter(),
            ],
            'this_year' => [
                'start' => Carbon::now()->startOfYear(),
                'end' => Carbon::now()->endOfYear(),
            ],
            'last_year' => [
                'start' => Carbon::now()->subYear()->startOfYear(),
                'end' => Carbon::now()->subYear()->endOfYear(),
            ],
            'last_30_days' => [
                'start' => Carbon::now()->subDays(30)->startOfDay(),
                'end' => Carbon::now()->endOfDay(),
            ],
            'last_60_days' => [
                'start' => Carbon::now()->subDays(60)->startOfDay(),
                'end' => Carbon::now()->endOfDay(),
            ],
            'last_90_days' => [
                'start' => Carbon::now()->subDays(90)->startOfDay(),
                'end' => Carbon::now()->endOfDay(),
            ],
            'custom' => null, // Custom range is handled above
            default => null,
        };
    }

    public function render()
    {
        $dateRange = $this->getDateRange();

        // Update heading to include date range
        $heading = __('Time Entries') . ' - ' . match($this->selectedDateFilter) {
            'today' => __('Today'),
            'yesterday' => __('Yesterday'),
            'this_week' => __('This Week'),
            'last_week' => __('Last Week'),
            'this_month' => __('This Month'),
            'last_month' => __('Last Month'),
            'this_quarter' => __('This Quarter'),
            'last_quarter' => __('Last Quarter'),
            'this_year' => __('This Year'),
            'last_year' => __('Last Year'),
            'last_30_days' => __('Last 30 Days'),
            'last_60_days' => __('Last 60 Days'),
            'last_90_days' => __('Last 90 Days'),
            'custom' => __('Custom Range'),
            default => __('All Time'),
        };

        $timeEntries = TimeEntry::query()
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('user_name', 'like', '%' . $this->search . '%')
                    ->orWhere('project_name', 'like', '%' . $this->search . '%')
                    ->orWhere('task_name', 'like', '%' . $this->search . '%');
            })
            ->when($dateRange, function ($query) use ($dateRange) {
                $query->whereBetween('time_interval_start', [$dateRange['start'], $dateRange['end']]);
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
            ->when($dateRange, function ($query) use ($dateRange) {
                $query->whereBetween('time_interval_start', [$dateRange['start'], $dateRange['end']]);
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
                $item->total_hours_numeric = round($hours, 2); // Numeric value for calculations
                $item->total_hours_decimal = number_format($hours, 2, ',', ''); // Formatted for display

                return $item;
            });

        // Get all users for the filter dropdown
        $users = TimeEntry::select('clockify_user_id', 'user_name')
            ->whereNotNull('user_name')
            ->distinct()
            ->orderBy('user_name')
            ->get();

        return view('livewire.time-entries.index', [
            'timeEntries' => $timeEntries,
            'projects' => $projects,
            'projectTotals' => $projectTotals,
            'users' => $users,
            'heading' => $heading,
        ]);
    }
}
