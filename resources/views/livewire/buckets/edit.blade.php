<section>
    @include('partials.heading', ['heading' => __('Update Bucket'), 'description' => __('Update bucket: ') . $identifier ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="identifier" :label="__('Identifier')" type="text" required autofocus autocomplete="identifier" />
        <flux:input wire:model="bucket_start_date" :label="__('Bucket Start Date')" type="date" required :description="__('Date the client approved or paid for the new bucket')" />

        <flux:select wire:model="client_id" :label="__('Client')" required>
            <option value="">{{ __('Select a client') }}</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </flux:select>

        <flux:input wire:model="sequence" :label="__('Sequence')" type="number" step="1" min="0" />
        <flux:input wire:model="hours" :label="__('Available Hours')" type="number" step="1" min="0" />
        <flux:input wire:model="cost_per_hour" :label="__('Cost Per Hour')" type="number" step="0.01" min="0" />

        <flux:select wire:model="payment_status" :label="__('Payment Status')" required>
            @foreach($paymentStatuses as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </flux:select>

        <flux:input wire:model="payment_date" :label="__('Payment Date')" type="date" :description="__('Date the payment was made (optional)')" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Update') }}</flux:button>
            </div>
        </div>
    </form>
</section>
