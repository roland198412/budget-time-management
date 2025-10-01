<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- First card: placeholder -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
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
                                $warningClass = $percentage >= 80 ? 'animate-pulse' : '';
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
