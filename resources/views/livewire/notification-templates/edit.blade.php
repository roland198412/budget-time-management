<section>
    @include('partials.heading', ['heading' => __('Update Notification Template'), 'description' => __('Update notification template: ' . $identifier) ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="identifier" :label="__('Identifier')" type="text" required autofocus autocomplete="identifier" />

        <flux:select wire:model="client_id" :label="__('Client')" required>
            <option value="">{{ __('Select a client') }}</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </flux:select>

        <flux:input wire:model="subject" :label="__('Subject Line')" type="subject" />

        <flux:select wire:model="channel" :label="__('Notification Channel')" required>
            <option value="">{{ __('Select a notification channel') }}</option>
            <option value="email">{{ __('Email') }}</option>
        </flux:select>

        <flux:textarea wire:model="content" :label="__('Content')" type="content" rows="20" />

        <flux:textarea wire:model="available_placeholders" :label="__('Available Placeholders')" type="available_placeholders" rows="20" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Update') }}</flux:button>
            </div>
        </div>
    </form>
</section>