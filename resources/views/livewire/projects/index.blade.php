<section>
    @include('partials.heading', ['heading' => __('Projects'), 'description' => __('Manage your projects') ])
    <div class="h-full w-full flex-1">
        <flux:button variant="primary" size="sm" :href="route('projects.create')" class="mb-4" >
            {{ __('Create') }}
        </flux:button>

        <div class="w-full align-middle">
            <table class="w-full divide-y  border-collapse border border-gray-400">
                <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Project Type') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Client') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Color') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Budget') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Remaining Budget') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Cost Per Hour') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Total Hours') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Available Hours') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Used Hours') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Created At') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Updated At') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</span>
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                @foreach($projects as $project)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->project_type ? ucfirst($project->project_type->value) : __('N/A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->client->name ?? __('N/A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            @if($project->color)
                                <div class="w-6 h-6 rounded" style="background-color: {{ $project->color }}"></div>
                            @else
                                {{ __('N/A') }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->budget ? 'R' . number_format($project->budget, 2) : __('N/A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->budget ? 'R' . number_format($project->remaining_budget, 2) : __('N/A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->cost_per_hour ? 'R' . number_format($project->cost_per_hour, 2) : __('N/A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->total_hours }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->available_hours }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->used_hours }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $project->updated_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border  border-gray-100 p-1">
                            <flux:button size="xs" variant="primary" :href="route('projects.edit', $project)">
                                {{ __('Edit') }}
                            </flux:button>

                            <flux:button size="xs" variant="danger" wire:click="delete({{ $project->id }})" wire:confirm="{{ __('Are you sure you want to delete this project?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $projects->links() }}
        </div>
    </div>
</section>