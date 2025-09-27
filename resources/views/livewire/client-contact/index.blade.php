<section>
    @include('partials.heading', ['heading' => __('Client Contacts'), 'description' => __('Manage your client contacts') ])
    <div class="h-full w-full flex-1">
        <flux:button variant="primary" size="sm" :href="route('client-contacts.create')" class="mb-4" >
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
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Client') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Full Name') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</span>
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
                @foreach($clientContacts as $clientContact)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $clientContact->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $clientContact->client->name ?? __('N/A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $clientContact->full_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $clientContact->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $clientContact->created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $clientContact->updated_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border  border-gray-100 p-1">
                            <flux:button size="xs" variant="primary" :href="route('client-contacts.edit', $clientContact)">
                                {{ __('Edit') }}
                            </flux:button>

                            <flux:button size="xs" variant="danger" wire:click="delete({{ $clientContact->id }})" wire:confirm="{{ __('Are you sure you want to delete this client contact?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $clientContacts->links() }}
        </div>
    </div>
</section>