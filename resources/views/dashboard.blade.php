<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- First card: placeholder -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>


            <!-- Second card: single bucket with client and gradient fill -->
            <div class="flex flex-col items-center justify-center relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-gray-100 dark:bg-neutral-900 p-4">
                @foreach($clients as $client)
                    <!-- Client name -->
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100 mb-4">
                        {{ $client->name }}
                    </h2>

                    <!-- Single Bucket -->
                    <div class="flex items-end justify-center gap-6">
                        <div class="flex flex-col items-center">
                            <div class="relative w-16 h-32 border-2 border-gray-600 dark:border-neutral-300 rounded-b-2xl overflow-hidden bg-gray-200 dark:bg-neutral-800">
                                <div
                                    id="bucket-{{ $client->id }}"
                                    class="absolute bottom-0 left-0 w-full transition-all duration-1000 ease-out"
                                    style="height: 0%; background-color: green;"
                                ></div>
                            </div>
                            <p class="mt-2 text-center text-sm text-gray-700 dark:text-neutral-300">
                                <strong>{{ __('Bucket') }}</strong><br>{{ $client->projects()->bucket()->first()->available_hours }} / {{ $client->projects()->bucket()->first()->total_hours }}
                            </p>
                        </div>
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
                const bucket{{ $client->id }} = {
                    id: "bucket-{{ $client->id }}",
                    used: {{ $client->projects()->bucket()->first()->total_hours }},
                    total: {{ $client->projects()->bucket()->first()->raw_available_hours }}
                };

                initializeBucket(bucket{{ $client->id }});
            @endforeach
        });

        function initializeBucket(bucket) {
            setTimeout(() => {
                const fillEl = document.getElementById(bucket.id);
                if (!fillEl) return;

                const percent = (bucket.used / bucket.total) * 100;

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
