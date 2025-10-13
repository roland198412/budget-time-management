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

                    <div class="space-y-3 mb-6">
                        <!-- Total Budget Bar -->
                        <div class="p-2 rounded-lg bg-gray-50 dark:bg-neutral-800/50">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="font-medium text-gray-700 dark:text-neutral-300">
                                    Total Budget
                                    @php
                                        $buckets = $client->buckets->sortBy('sequence');
                                        $allocatedBuckets = \App\Helpers\BucketAllocator::allocate($buckets);
                                        $activeBucketCount = $allocatedBuckets->filter(fn($b) => $b->hours > 0 && $b->used < $b->hours)->count();
                                    @endphp
                                    <span class="inline-flex items-center ml-2 px-1.5 py-0.5 rounded-full text-xs font-medium {{ $activeBucketCount > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $activeBucketCount }} {{ __('Active Bucket'.($activeBucketCount !== 1 ? 's' : '')) }}
                                    </span>
                                </span>
                                <span class="text-gray-900 dark:text-neutral-100 font-semibold">
                                    R {{ number_format($client->total_budget, 2) }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>

                        <!-- Paid Hours Bar -->
                        <div class="p-2 rounded-lg {{ $client->total_paid > $client->total_budget ? 'bg-red-50 dark:bg-red-950/20' : 'bg-gray-50 dark:bg-neutral-800/50' }}">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="font-medium text-gray-700 dark:text-neutral-300">
                                    Paid to Developers
                                    @if($client->total_paid > $client->total_budget)
                                        <span class="inline-flex items-center ml-2 px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Over Budget
                                        </span>
                                    @endif
                                </span>
                                <span class="{{ $client->total_paid > $client->total_budget ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-900 dark:text-neutral-100' }}">
                                    R {{ number_format($client->total_paid, 2) }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full transition-all duration-300"
                                     style="width: @if($client->total_budget > 0){{ min(($client->total_paid / $client->total_budget) * 100, 100) }}@else 0 @endif%">
                                </div>
                            </div>
                        </div>

                        <div class="p-2 rounded-lg bg-gray-50 dark:bg-neutral-800/50">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="font-medium text-gray-700 dark:text-neutral-300">
                                    Amount Owed to Developers
                                </span>
                                <span class="{{ $client->total_amount_outstanding_to_developers > 0 ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-900 dark:text-neutral-100' }}">
                                    R {{ number_format($client->total_amount_outstanding_to_developers, 2) }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="{{ $client->total_amount_outstanding_to_developers > 0 ? 'bg-red-500' : 'bg-gray-200' }} h-2 rounded-full transition-all duration-300" style="width: @if($client->total_amount_outstanding_to_developers > 0){{ min(($client->total_paid / $client->total_budget) * 100, 100) }}@else 0 @endif%">
                                </div>
                            </div>
                        </div>

                        <!-- Available Balance Bar -->
                        <div class="p-2 rounded-lg {{ ($client->total_budget - $client->total_paid) < ($client->total_budget * 0.2) ? 'bg-red-50 dark:bg-red-950/20' : 'bg-gray-50 dark:bg-neutral-800/50' }}">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="font-medium text-gray-700 dark:text-neutral-300">
                                    Available in Bank
                                    @if(($client->total_budget - $client->total_paid) < ($client->total_budget * 0.2))
                                        <span class="inline-flex items-center ml-2 px-1.5 py-0.5 rounded-full text-xs font-medium {{ ($client->total_budget - $client->total_paid) < 0 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' }}">
                                            {{ ($client->total_budget - $client->total_paid) < 0 ? 'Negative Balance' : 'Low Balance' }}
                                        </span>
                                    @endif
                                </span>
                                <span class="{{ ($client->total_budget - $client->total_paid) < 0 ? 'text-red-600 dark:text-red-400 font-semibold' : (($client->total_budget - $client->total_paid) < ($client->total_budget * 0.2) ? 'text-orange-600 dark:text-orange-400 font-semibold' : 'text-green-600 dark:text-green-400 font-semibold') }}">
                                    R {{ number_format($client->total_budget - $client->total_paid, 2) }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full transition-all duration-300"
                                     style="width: @if($client->total_budget > 0){{ max(min((($client->total_budget - $client->total_paid) / $client->total_budget) * 100, 100), 0) }}@else 0 @endif%">
                                </div>
                            </div>
                        </div>
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

            <!-- Second card: Bucket Overview -->
            <div class="flex flex-col items-start justify-start relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-gray-100 dark:bg-neutral-900 p-4">
                @foreach($clients as $client)
                    <div class="w-full">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">
                                {{ $client->name }}
                            </h2>
                            <span class="text-sm text-gray-500 dark:text-neutral-400">Bucket Overview</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-50 dark:bg-neutral-800 p-2 rounded-lg mb-3">
                            <span class="text-sm font-semibold text-gray-700 dark:text-neutral-300">Bucket Overview</span>
                            <div class="flex items-center gap-2">
                                @php
                                    $buckets = $client->buckets->sortBy('sequence');
                                    $allocatedBuckets = \App\Helpers\BucketAllocator::allocate($buckets);
                                    $activeBucketCount = $allocatedBuckets->filter(fn($b) => $b->hours > 0 && $b->used < $b->hours)->count();
                                    $depletedBucketCount = $allocatedBuckets->filter(fn($b) => $b->hours > 0 && $b->used >= $b->hours)->count();
                                @endphp
                                <span class="text-xs {{ $activeBucketCount > 0 ? 'text-gray-500 dark:text-neutral-400' : 'text-red-500 dark:text-red-400' }}">
                                    {{ $activeBucketCount }} {{ __('Active') }}
                                </span>
                                @if($depletedBucketCount > 0)
                                    <span class="text-xs text-red-500 dark:text-red-400">
                                        {{ $depletedBucketCount }} {{ __('Depleted') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        @php
                            $buckets = $client->buckets->sortBy('sequence');
                            $buckets = \App\Helpers\BucketAllocator::allocate($buckets)->sortByDesc('sequence');
                            $activeBuckets = $buckets->filter(fn($b) => $b->hours > 0 && $b->used < $b->hours);
                            $depletedBuckets = $buckets->filter(fn($b) => $b->hours > 0 && $b->used >= $b->hours);
                        @endphp
                        <div class="space-y-3 overflow-y-auto max-h-[calc(100vh-24rem)]">
                            @foreach($activeBuckets as $bucket)
                                @php
                                    $percentage = ($bucket->used / $bucket->hours) * 100;
                                    $remainingHours = $bucket->hours - $bucket->used;
                                    $statusColor = match(true) {
                                        $percentage >= 80 => 'bg-orange-500',
                                        $percentage >= 50 => 'bg-yellow-500',
                                        default => 'bg-green-500'
                                    };
                                @endphp
                                <div class="p-2 rounded-lg {{ $percentage >= 80 ? 'bg-red-50 dark:bg-red-950/20' : 'bg-gray-50 dark:bg-neutral-800/50' }}">
                                    <div class="flex justify-between items-center text-sm mb-2">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-700 dark:text-neutral-300">
                                                {{ $bucket->identifier ?? "Bucket " . $bucket->sequence }}
                                                @if($percentage >= 80)
                                                    <span class="inline-flex items-center ml-2 px-1.5 py-0.5 rounded-full text-xs font-medium {{ $percentage >= 100 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' }}">
                                                        {{ $percentage >= 100 ? 'Depleted' : 'Warning' }}
                                                    </span>
                                                @endif
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-neutral-500">
                                                {{ number_format($remainingHours, 2) }}h remaining
                                            </span>
                                        </div>
                                        <span class="{{ $percentage >= 80 ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-600 dark:text-neutral-400' }}">
                                            {{ number_format($bucket->used, 2) }}/{{ number_format($bucket->hours, 2) }}h
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                        <div class="{{ $statusColor }} h-2 rounded-full transition-all duration-300"
                                             style="width: {{ min($percentage, 100) }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($depletedBuckets->isNotEmpty())
                                <div class="border-t border-gray-200 dark:border-neutral-700 pt-3 mt-3">
                                    <span class="text-xs font-medium text-red-500 dark:text-red-400 mb-2 block">Depleted Buckets</span>
                                    @foreach($depletedBuckets as $bucket)
                                        @php
                                            $remainingHours = $bucket->hours - $bucket->used;
                                        @endphp
                                        <div class="p-2 rounded-lg bg-red-50 dark:bg-red-950/20">
                                            <div class="flex justify-between items-center text-sm mb-2">
                                                <div class="flex flex-col">
                                                    <span class="font-medium text-gray-700 dark:text-neutral-300">
                                                        {{ $bucket->identifier ?? "Bucket " . $bucket->sequence }}
                                                        <span class="inline-flex items-center ml-2 px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                            Depleted
                                                        </span>
                                                    </span>
                                                    <span class="text-xs text-red-500 dark:text-red-500">
                                                        {{ number_format(abs($remainingHours), 2) }}h over budget
                                                    </span>
                                                </div>
                                                <span class="text-red-600 dark:text-red-400 font-semibold">
                                                    {{ number_format($bucket->used, 2) }}/{{ number_format($bucket->hours, 2) }}h
                                                </span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                                                <div class="bg-red-500 h-2 rounded-full transition-all duration-300"
                                                     style="width: 100%">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Lower section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

</x-layouts.app>
