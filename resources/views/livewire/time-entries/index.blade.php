<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Time Entries</h2>
                    </div>

                    @if (session()->has('message'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <input wire:model.live="search" 
                               type="text" 
                               placeholder="Search time entries..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th wire:click="sortBy('time_interval_start')" 
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                        Start Time
                                        @if($sortBy === 'time_interval_start')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('description')" 
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                        Description
                                        @if($sortBy === 'description')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('user_name')" 
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                        User
                                        @if($sortBy === 'user_name')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('project_name')" 
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                        Project
                                        @if($sortBy === 'project_name')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @endif
                                    </th>
                                    <th wire:click="sortBy('duration')" 
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                        Duration
                                        @if($sortBy === 'duration')
                                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                                        @endif
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Billable
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($timeEntries as $timeEntry)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $timeEntry->time_interval_start ? $timeEntry->time_interval_start->format('Y-m-d H:i') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="max-w-xs truncate">
                                                {{ $timeEntry->description ?? 'No description' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $timeEntry->user_name ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                @if($timeEntry->project_color)
                                                    <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $timeEntry->project_color }}"></div>
                                                @endif
                                                {{ $timeEntry->project_name ?? 'Unknown' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $timeEntry->duration ? gmdate('H:i:s', $timeEntry->duration) : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($timeEntry->billable)
                                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Yes</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button wire:click="delete({{ $timeEntry->id }})" 
                                                    wire:confirm="Are you sure you want to delete this time entry?"
                                                    class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No time entries found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $timeEntries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
