<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- First card: Budget Overview -->
            <div class="flex flex-col items-start justify-start relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-gray-100 dark:bg-neutral-900 p-6">
                @foreach($clients as $client)
                <div class="w-full mb-6 last:mb-0">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">
                            {{ $client->name }}
                        </h2>
                        <span class="text-sm text-gray-500 dark:text-neutral-400">Budget Overview</span>
                    </div>

                    <!-- Total Budget Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700 dark:text-neutral-300">Total Budget</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-neutral-100">
                                R {{ number_format($client->total_budget, 2) }} ({{ $client->buckets()->count() }} {{ __('Buckets') }})
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>

                    <!-- Paid Hours Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700 dark:text-neutral-300">Paid to Developers</span>
                            <span class="text-sm font-semibold {{ $client->total_paid > $client->total_budget ? 'text-red-500' : 'text-gray-900 dark:text-neutral-100' }}">
                                R {{ number_format($client->total_paid, 2) }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2.5">
                            <div class="bg-orange-500 h-2.5 rounded-full transition-all duration-300"
                                 style="width: {{ $client->total_budget > 0 ? min(($client->total_paid / $client->total_budget) * 100, 100) : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Available Balance Bar -->
                    <div class="mb-2">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700 dark:text-neutral-300">Available in Bank</span>
                            <span class="text-sm font-semibold {{ ($client->total_budget - $client->total_paid) < 0 ? 'text-red-500' : 'text-green-600' }}">
                                R {{ number_format($client->total_budget - $client->total_paid, 2) }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full transition-all duration-300"
                                 style="width: {{ $client->total_budget > 0 ? max(min((($client->total_budget - $client->total_paid) / $client->total_budget) * 100, 100), 0) : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Individual Bucket Status -->
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-neutral-300">Bucket Status</span>
                        </div>
                        @php
                            $buckets = $client->buckets->sortBy('sequence');
                            $buckets = \App\Helpers\BucketAllocator::allocate($buckets)->sortByDesc('sequence');
                        @endphp
                        @foreach($buckets as $bucket)
                            @php
                                $percentage = $bucket->hours > 0 ? ($bucket->used / $bucket->hours) * 100 : 0;
                                $statusColor = match(true) {
                                    $percentage >= 100 => 'bg-red-500',
                                    $percentage >= 80 => 'bg-orange-500',
                                    $percentage >= 50 => 'bg-yellow-500',
                                    default => 'bg-green-500'
                                };
                            @endphp
                            <div class="space-y-1">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-medium text-gray-600 dark:text-neutral-400">
                                        {{ $bucket->identifier ?? "Bucket " . $bucket->sequence }}
                                    </span>
                                    <span class="{{ $percentage >= 80 ? 'text-red-500 font-semibold' : 'text-gray-600 dark:text-neutral-400' }}">
                                        {{ number_format($bucket->used, 2) }}/{{ number_format($bucket->hours, 2) }}h
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-1.5">
                                    <div class="{{ $statusColor }} h-1.5 rounded-full transition-all duration-300"
                                         style="width: {{ min($percentage, 100) }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($client->total_budget > 0 && ($client->total_budget - $client->total_paid) < ($client->total_budget * 0.2))
                        <p class="text-sm text-red-500 mt-2">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Low balance warning
                        </p>
                    @endif
                </div>
                @endforeach
            </div>


            <!-- Second card: buckets with client and gradient fill -->
            <div class="flex flex-col items-center justify-center relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-gray-100 dark:bg-neutral-900 p-4">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>

            <!-- Third card: placeholder -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>

        <!-- Lower section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

</x-layouts.app>
