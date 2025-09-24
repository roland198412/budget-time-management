<section>
    @include('partials.heading', ['heading' => __('Create Bucket'), 'description' => __('Create new bucket') ])

    <form wire:submit="save" class="my-6 w-full space-y-6">
        <flux:input wire:model="identifier" :label="__('Identifier')" type="text" required autofocus autocomplete="identifier" />
        <flux:input wire:model="bucket_start_date" :label="__('Bucket Start Date')" type="date" required :description="__('Date the client approved or paid for the new bucket')" />

        <flux:select wire:model.live="client_id" :label="__('Client')" required>
            <option value="">{{ __('Select a client') }}</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </flux:select>

        @if(!empty($projects))
            <div>
                <label for="projects" class="block font-medium text-sm text-gray-700">{{ __('Projects') }}</label>
                <select wire:model="project_ids" id="projects" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach($projects as $project)
                        <option value="{{ $project['id'] }}">{{ $project['name'] }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <flux:input wire:model="hours" :label="__('Available Hours')" type="number" step="1" min="0" />
        <flux:input wire:model="cost_per_hour" :label="__('Cost Per Hour')" type="number" step="0.01" min="0" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button size="sm" variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
            </div>
        </div>
    </form>
</section>
