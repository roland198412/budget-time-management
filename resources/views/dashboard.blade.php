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
                @foreach($clients as $client)
                    <!-- Client name with warning indicator -->
                    <div class="flex items-center gap-2 mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">
                            {{ $client->name }}
                        </h2>
                        @php
                            $buckets = $client->buckets->sortBy('sequence');
                            $buckets = \App\Helpers\BucketAllocator::allocate($buckets);
                            $hasLowBucket = $buckets->contains(function($bucket) {
                                return $bucket->hours > 0 && ($bucket->used / $bucket->hours) >= 0.8;
                            });
                        @endphp
                        @if($hasLowBucket)
                            <span class="animate-pulse flex h-3 w-3 relative">
                                <span class="absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                            </span>
                        @endif
                    </div>

                    <!-- Multiple Buckets -->
                    <div class="flex items-end justify-center gap-6">
                        @foreach($buckets as $bucket)
                            @php
                                $totalHours = $bucket->hours;
                                $usedHours = $bucket->used;
                                $percentage = $totalHours > 0 ? ($usedHours / $totalHours) * 100 : 0;
                                $warningClass = $totalHours > 0 && $percentage >= 80 ? 'animate-pulse' : '';
                            @endphp
                            <div class="flex flex-col items-center {{ $warningClass }}">
                                <div class="relative w-16 h-32 border-2 border-gray-600 dark:border-neutral-300 rounded-b-2xl overflow-hidden bg-gray-200 dark:bg-neutral-800">
                                    <div
                                        id="bucket-{{ $client->id }}-{{ $bucket->id }}"
                                        class="absolute bottom-0 left-0 w-full transition-all duration-1000 ease-out"
                                        style="height: 0%; background-color: green;"
                                    ></div>
                                </div>
                                <div class="mt-2 text-center">
                                    <p class="text-sm font-medium text-gray-700 dark:text-neutral-300">
                                        {{ $bucket->identifier ?? __('Bucket') }}
                                    </p>
                                    <p class="text-sm {{ $percentage >= 80 ? 'text-red-500 font-bold' : 'text-gray-600 dark:text-neutral-400' }}">
                                        {{ number_format($usedHours, 2) }} / {{ number_format($totalHours, 2) }}
                                    </p>
                                    @if($totalHours > 0 && $percentage >= 80)
                                        <p class="text-xs text-red-500 font-semibold mt-1">
                                            {{ number_format($totalHours - $usedHours, 1) }}h left
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
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

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @foreach($clients as $client)
                @php
                    $allocatedBuckets = \App\Helpers\BucketAllocator::allocate($client->buckets->sortBy('sequence'));
                @endphp
                @foreach($allocatedBuckets as $bucket)
                    const bucket{{ $client->id }}{{ $bucket->id }} = {
                        id: "bucket-{{ $client->id }}-{{ $bucket->id }}",
                        used: {{ $bucket->used }},
                        total: {{ $bucket->hours }}
                    };

                    initializeBucket(bucket{{ $client->id }}{{ $bucket->id }});
                @endforeach
            @endforeach
        });

        function initializeBucket(bucket) {
            setTimeout(() => {
                const fillEl = document.getElementById(bucket.id);
                if (!fillEl) return;

                const percent = bucket.total > 0 ? (bucket.used / bucket.total) * 100 : 0;

                // Animate height
                fillEl.style.height = `${percent}%`;

                // Animate color gradient smoothly
                let current = 0;
                const interval = setInterval(() => {
                    if (current >= percent) {
                        clearInterval(interval);
                    } else {
                        current += 1;
                        fillEl.style.backgroundColor = getFillColor(current);
                    }
                }, 10);
            }, 300);
        }

        function getFillColor(percent) {
            if (percent >= 100) return '#ef4444'; // Red-500
            if (percent >= 80) return '#f97316';  // Orange-500
            if (percent >= 50) return '#eab308';  // Yellow-500
            return '#22c55e'; // Green-500
        }
    </script>
</x-layouts.app>
