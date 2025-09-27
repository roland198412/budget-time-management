<section>
    @include('partials.heading', ['heading' => __('Update Client Contact'), 'description' => __('Update client contact: ') . $firstname . ' ' . $lastname ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="firstname" :label="__('First Name')" type="text" required autofocus autocomplete="firstname" />
        <flux:input wire:model="lastname" :label="__('Last Name')" type="text" required />
        <flux:input wire:model="email" :label="__('Email')" type="email" required />

        <flux:select wire:model="client_id" :label="__('Client')" required>
            <option value="">{{ __('Select a client') }}</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </flux:select>

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Update') }}</flux:button>
            </div>
        </div>
    </form>

</section>