<?php

namespace App\Helpers;

use App\Models\Client;

class BucketHelper
{
    /**
     * Calculate the remaining hours for a client's buckets.
     *
     * This method computes the difference between the total hours allocated
     * to a client's buckets and the total bucket duration (converted from seconds to hours).
     *
     * @param Client $client The client whose bucket hours are being calculated.
     * @return string The remaining hours formatted as a string with two decimal places,
     *                using a comma as the decimal separator.
     */
    public static function bucketRemainingHours(Client $client): string
    {
        // Retrieve the buckets associated with the client
        $buckets = $client->buckets;

        // Calculate the total hours from all buckets
        $totalHours = $buckets->sum('hours');

        // Get the total bucket duration for the client (in seconds)
        $totalDuration = $client->total_bucket_duration;

        // Calculate the remaining hours and format the result
        return number_format($totalHours - ($totalDuration / 3600), 2, ',', '');
    }
}