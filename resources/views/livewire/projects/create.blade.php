<section>
    @include('partials.heading', ['heading' => __('New Project'), 'description' => __('Create new project') ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
        
        <flux:select wire:model="project_type" :label="__('Project Type')" required>
            <option value="">{{ __('Select a project type') }}</option>
            <option value="fixed">{{ __('Fixed') }}</option>
            <option value="bucket">{{ __('Bucket') }}</option>
        </flux:select>
        
        <flux:select wire:model="client_id" :label="__('Client')" required>
            <option value="">{{ __('Select a client') }}</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </flux:select>

        <flux:input wire:model="color" :label="__('Color')" type="color" />
        
        <flux:input wire:model="clockify_project_id" :label="__('Clockify Project Id')" type="text" autocomplete="clockify_project_id" />
        
        <flux:input wire:model="budget" :label="__('Budget')" type="number" step="0.01" min="0" />
        
        <flux:input wire:model="cost_per_hour" :label="__('Cost Per Hour')" type="number" step="0.01" min="0" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
            </div>
        </div>
    </form>

</section>