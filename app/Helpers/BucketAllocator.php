<?php

namespace App\Helpers;

use App\Models\{Client};
use Illuminate\Support\Collection;

class BucketAllocator
{
    /**
     * Allocate usage into buckets for one or many clients.
     *
     */
    public static function allocate($buckets): Collection|\Illuminate\Pagination\LengthAwarePaginator
    {
        // Group by client, so overflow never crosses clients
        $grouped = $buckets->groupBy('client_id');

        foreach ($grouped as $clientId => $clientBuckets) {
            $totalUsed = Client::find($clientId)->total_bucket_duration / 3600;
            $remaining = $totalUsed;

            foreach ($clientBuckets as $bucket) {
                $allocated = min($bucket->hours, $remaining);

                $bucket->used = $allocated;
                $bucket->remaining = $bucket->hours - $allocated;

                $remaining -= $allocated;
            }
        }

        return $buckets;
    }
}
