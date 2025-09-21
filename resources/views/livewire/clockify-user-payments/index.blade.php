<section>
    @include('partials.heading', ['heading' => __('Clockify User Payments'), 'description' => __('Manage user payments') ])
    <div class="h-full w-full flex-1">
        <flux:button variant="primary" size="sm" :href="route('clockify-user-payments.create')" class="mb-4" >
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
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount Ex VAT') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('VAT Amount') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Payment Date') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Projects') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Created At') }}</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left border   border-gray-100">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</span>
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                @foreach($payments as $payment)
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $payment->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ number_format($payment->amount_ex_vat, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ number_format($payment->vat_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $payment->payment_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            @if($payment->projects->count() > 0)
                                <div class="space-y-1">
                                    @foreach($payment->projects as $project)
                                        <div class="flex items-center">
                                            @if($project->color)
                                                <div class="w-4 h-4 rounded mr-2" style="background-color: {{ $project->color }}"></div>
                                            @endif
                                            <span class="text-xs">{{ $project->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-500 text-xs">No projects</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border   border-gray-100 p-1">
                            {{ $payment->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 border  border-gray-100 p-1">
                            <flux:button size="xs" variant="primary" :href="route('clockify-user-payments.edit', $payment)">
                                {{ __('Edit') }}
                            </flux:button>

                            <flux:button size="xs" variant="danger" wire:click="delete({{ $payment->id }})" wire:confirm="{{ __('Are you sure you want to delete this payment?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $payments->links() }}
        </div>
    </div>
</section>