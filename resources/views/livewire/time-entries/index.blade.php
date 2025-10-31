<section>
    @include('partials.heading', [
        'heading' => $heading ?? __('Time Entries'),
        'description' => __('Manage your time entries')
    ])

    <div class="h-full w-full flex-1">
        @if (session()->has('message'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('message') }}
            </div>
        @endif

        <!-- Search and Filters Section -->
        <div class="mb-4 space-y-4">
            <!-- Search -->
            <div>
                <input wire:model.live="search" 
                       type="text" 
                       placeholder="Search time entries..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Date Filter -->
                <div>
                    <flux:field>
                        <flux:label>{{ __('Date Range') }}</flux:label>
                        <flux:select wire:model.live="selectedDateFilter">
                            <flux:select.option value="today">{{ __('Today') }}</flux:select.option>
                            <flux:select.option value="yesterday">{{ __('Yesterday') }}</flux:select.option>
                            <flux:select.option value="this_week">{{ __('This Week') }}</flux:select.option>
                            <flux:select.option value="last_week">{{ __('Last Week') }}</flux:select.option>
                            <flux:select.option value="this_month">{{ __('This Month') }}</flux:select.option>
                            <flux:select.option value="last_month">{{ __('Last Month') }}</flux:select.option>
                            <flux:select.option value="this_quarter">{{ __('This Quarter') }}</flux:select.option>
                            <flux:select.option value="last_quarter">{{ __('Last Quarter') }}</flux:select.option>
                            <flux:select.option value="this_year">{{ __('This Year') }}</flux:select.option>
                            <flux:select.option value="last_year">{{ __('Last Year') }}</flux:select.option>
                            <flux:select.option value="last_30_days">{{ __('Last 30 Days') }}</flux:select.option>
                            <flux:select.option value="last_60_days">{{ __('Last 60 Days') }}</flux:select.option>
                            <flux:select.option value="last_90_days">{{ __('Last 90 Days') }}</flux:select.option>
                            <flux:select.option value="all">{{ __('All Time') }}</flux:select.option>
                        </flux:select>
                    </flux:field>
                </div>

                <!-- Project Filter -->
                <div class="flex gap-4 *:gap-x-2">
                    <flux:checkbox.group wire:model.live="selectedProjects" label="Projects">
                        @foreach($projects as $project)
                            <flux:checkbox label="{{ $project->name }}" value="{{ $project->clockify_project_id }}" checked />
                        @endforeach
                    </flux:checkbox.group>
                </div>
                
                <!-- User Filter -->
                <div>
                    <flux:checkbox.group wire:model.live="selectedUsers" label="Users">
                        @foreach($users as $user)
                            <flux:checkbox label="{{ $user->user_name }}" value="{{ $user->clockify_user_id }}" checked />
                        @endforeach
                    </flux:checkbox.group>
                </div>
            </div>
        </div>

        <div class="w-full align-middle">
            <table class="w-full divide-y border-collapse border border-gray-400">
                <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Start Date') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('End Date') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Start Time') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('End Time') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Duration (h)') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Duration (decimal)') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('User') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Project') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</span>
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                @forelse($timeEntries as $timeEntry)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $timeEntry->time_interval_start ? $timeEntry->time_interval_start->format('d-m-Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $timeEntry->time_interval_end ? $timeEntry->time_interval_end->format('d-m-Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $timeEntry->time_interval_start ? $timeEntry->time_interval_start->format('H:i:s') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $timeEntry->time_interval_end ? $timeEntry->time_interval_end->format('H:i:s') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $timeEntry->duration ? gmdate('H:i:s', $timeEntry->duration) : '00:00:00' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $timeEntry->duration_decimal }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            <div class="max-w-xs truncate">
                                {{ $timeEntry->description ?? 'No description' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $timeEntry->user_name ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            <div class="flex items-center">
                                @if($timeEntry->project_color)
                                    <div class="w-6 h-6 rounded mr-2" style="background-color: {{ $timeEntry->project_color }}"></div>
                                @endif
                                {{ $timeEntry->project_name ?? 'Unknown' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            <flux:button size="xs" variant="danger" wire:click="delete({{ $timeEntry->id }})" wire:confirm="{{ __('Are you sure you want to delete this time entry?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500 border border-gray-100">
                            No time entries found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $timeEntries->links() }}
        </div>

        <!-- Project Totals Widget -->
        @if($projectTotals->isNotEmpty())
            <div class="mt-6 bg-white border border-gray-300 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Project Hours Summary') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($projectTotals as $projectTotal)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                @if($projectTotal->project_color)
                                    <div class="w-4 h-4 rounded mr-2" style="background-color: {{ $projectTotal->project_color }}"></div>
                                @endif
                                <span class="text-sm font-medium text-gray-900 truncate">
                        {{ $projectTotal->project_name ?? 'Unknown Project' }}
                    </span>
                            </div>
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $projectTotal->total_hours_decimal }}h
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total Hours Display -->
                <div class="mt-4 pt-4 border-t border-gray-300">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-lg p-4 max-w-xs">
                        <div class="text-sm font-medium text-gray-600 mb-1">{{ __('Total Hours') }}</div>
                        <div class="text-4xl font-bold text-blue-600">
                            {{ number_format($projectTotals->sum('total_hours_numeric'), 2, ',', '') }}h
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
