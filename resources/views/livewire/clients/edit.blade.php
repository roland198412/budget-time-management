<section>
    @include('partials.heading', ['heading' => __('Update Client'), 'description' => __('Update client: ') . $name ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
        <flux:input wire:model="clockify_client_id" :label="__('Clockify Client Id')" type="text" required autofocus autocomplete="clockify_client_id" />
        <flux:input wire:model="clockify_workspace_id" :label="__('Clockify Workspace Id')" type="text" required autofocus autocomplete="clockify_workspace_id" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Update') }}</flux:button>
            </div>
        </div>
    </form>

</section>