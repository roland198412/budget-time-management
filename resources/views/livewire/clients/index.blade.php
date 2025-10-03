<section>
    @include('partials.heading', ['heading' => __('Clients'), 'description' => __('Manage your clients') ])
    <div class="h-full w-full flex-1">
        <flux:button variant="primary" size="sm" :href="route('clients.create')" class="mb-4" >
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
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Cost per Hour') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Clockify Client Id') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Clockify Workspace Id') }}</span>
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
                @foreach($clients as $client)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $client->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $client->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $client->cost_per_hour }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $client->clockify_client_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $client->clockify_workspace_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $client->created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $client->updated_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border  border-gray-100 p-1">
                            <flux:button size="xs" variant="primary" :href="route('clients.edit', $client)">
                                {{ __('Edit') }}
                            </flux:button>

                            <flux:button size="xs" variant="danger" wire:click="delete({{ $client->id }})" wire:confirm="{{ __('Are you sure you want to delete this client?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $clients->links() }}
        </div>
    </div>
</section>
