<section>
    @include('partials.heading', ['heading' => __('Edit Clockify User'), 'description' => __('Update clockify user details') ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
        
        <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />
        
        <flux:input wire:model="clockify_user_id" :label="__('Clockify User Id')" type="text" autocomplete="clockify_user_id" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Update') }}</flux:button>
            </div>
        </div>
    </form>

</section>