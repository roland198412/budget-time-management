<section>
    @include('partials.heading', ['heading' => __('Buckets'), 'description' => __('Manage your Buckets') ])
    <div class="h-full w-full flex-1">
        <flux:button variant="primary" size="sm" :href="route('buckets.create')" class="mb-4" >
            {{ __('Create') }}
        </flux:button>
        <flux:select wire:model.live="client" placeholder="{{ __('Choose client...') }}" class="mb-4">
            <flux:select.option value=""> {{ __('Choose client...') }}</flux:select.option>
            @foreach($clients as $client)
                <flux:select.option value="{{ $client->id }}" wire:key="{{ $client->id }}">
                    {{ $client->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <div class="w-full align-middle">
            <table class="w-full divide-y border-collapse border border-gray-400">
                <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Client') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Identifier') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Payment Status') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            <div>{{ __('Bucket Start Date') }}</div>
                            <div class="text-xs text-gray-300 mt-1">({{ __('Invoice date') }})</div>
                        </span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Hours') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Hours Used') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Remaining Hours') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Cost per Hour') }}</span>
                    </th>

                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Created At') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Updated At') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</span>
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                @foreach($buckets as $bucket)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->client->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->identifier }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-xs leading-5 text-gray-900 border border-gray-100 p-1 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-normal
                                {{ $bucket->payment_status->value === 'paid' ? 'bg-green-200 text-green-900' : 'bg-red-200 text-red-900' }}">
                                {{ $bucket->payment_status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->bucket_start_date }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->hours }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->used }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->hours - $bucket->used }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->cost_per_hour }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            {{ $bucket->updated_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border border-gray-100 p-1">
                            <flux:button size="xs" variant="primary" :href="route('buckets.edit', $bucket)">
                                {{ __('Edit') }}
                            </flux:button>

                            <flux:button size="xs" variant="danger" wire:click="delete({{ $bucket->id }})" wire:confirm="{{ __('Are you sure you want to delete this bucket?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</section>