<section>
    @include('partials.heading', ['heading' => __('Time Entries'), 'description' => __('Manage your time entries') ])
    
    <div class="h-full w-full flex-1">
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
    </div>
</section>
