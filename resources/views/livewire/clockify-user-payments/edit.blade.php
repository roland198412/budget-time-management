<section>
    @include('partials.heading', ['heading' => __('Edit Payment'), 'description' => __('Edit user payment') ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:field>
            <flux:label>{{ __('User') }}</flux:label>
            <flux:select wire:model="clockify_user_id" placeholder="{{ __('Choose user...') }}" required>
                @foreach($users as $user)
                    <flux:select.option value="{{ $user->clockify_user_id }}">{{ $user->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>
        
        <flux:input wire:model="amount_ex_vat" :label="__('Amount Ex VAT')" type="number" step="0.01" min="0" required />
        <flux:input wire:model="vat_amount" :label="__('VAT Amount')" type="number" step="0.01" min="0" required />
        <flux:input wire:model="payment_date" :label="__('Payment Date')" type="date" required />

        <flux:field>
            <flux:label>{{ __('Payment Type') }}</flux:label>
            <flux:select wire:model="payment_type" placeholder="{{ __('Choose payment type...') }}" required>
                @foreach($paymentTypes as $type)
                    <flux:select.option value="{{ $type->value }}">{{ $type->value }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>

        <flux:field>
            <flux:label>{{ __('Payment Status') }}</flux:label>
            <flux:select wire:model="payment_status" placeholder="{{ __('Choose payment status...') }}" required>
                @foreach($paymentStatuses as $status)
                    <flux:select.option value="{{ $status->value }}">{{ $status->value }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>

        <div class="space-y-2">
            <flux:label>{{ __('Projects') }}</flux:label>
            <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-3">
                @foreach($projects as $project)
                    <label class="flex items-center space-x-2">
                        <input 
                            type="checkbox" 
                            wire:model="selectedProjects" 
                            value="{{ $project->id }}"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        <div class="flex items-center">
                            @if($project->color)
                                <div class="w-4 h-4 rounded mr-2" style="background-color: {{ $project->color }}"></div>
                            @endif
                            <span class="text-sm">{{ $project->name }}</span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Update') }}</flux:button>
            </div>
        </div>
    </form>

</section>