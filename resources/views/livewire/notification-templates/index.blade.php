<section>
    @include('partials.heading', ['heading' => __('Notification Templates'), 'description' => __('Manage your notification templates') ])
    <div class="h-full w-full flex-1">
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        <flux:button variant="primary" size="sm" :href="route('notification-templates.create')" class="mb-4" >
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
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Identifier') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Client') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Template Type') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Subject') }}</span>
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
                @foreach($notificationTemplates as $template)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $template->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $template->identifier }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $template->client->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $template->template_type?->label() ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $template->subject }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $template->created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $template->updated_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border  border-gray-100 p-1">
                            <flux:button size="xs" variant="primary" :href="route('notification-templates.edit', $template)">
                                {{ __('Edit') }}
                            </flux:button>

                            <flux:button size="xs" variant="ghost" wire:click="duplicate({{ $template->id }})" wire:confirm="{{ __('Are you sure you want to duplicate this template?') }}">
                                {{ __('Duplicate') }}
                            </flux:button>

                            <flux:button size="xs" variant="danger" wire:click="delete({{ $template->id }})" wire:confirm="{{ __('Are you sure you want to delete this template?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $notificationTemplates->links() }}
        </div>
    </div>
</section>
