<section>
    @include('partials.heading', ['heading' => __('New Client'), 'description' => __('Create new client') ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
            </div>
        </div>
    </form>

</section>
