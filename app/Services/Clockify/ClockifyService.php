<?php

namespace App\Services\Clockify;

use App\Models\Client;
use Illuminate\Support\Facades\Http;

class ClockifyService
{
    private string $apiKey = '';
    private string $baseUrl = 'https://api.clockify.me/api/v1';
    private string $reportsBaseUrl = 'https://reports.api.clockify.me/v1';

    public function __construct()
    {
        $this->apiKey = config('services.clockify.api_key');
    }

    /**
     * Fetches the projects associated with a specific client from the Clockify API.
     *
     * @param Client $client The client whose projects need to be fetched.
     *
     * @return array The array of projects retrieved from the API.
     *
     * @throws \Exception If the API request fails or an error occurs.
     */
    public function getProjectsByClient(Client $client): array
    {
        $url = "{$this->baseUrl}/workspaces/{$client->clockify_workspace_id}/projects";

        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
        ])->get($url, [
            'clients' => $client->clockify_client_id,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("Failed to fetch projects: " . $response->body());
    }

    /**
     * @param Client $client
     * @return array
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function getClientUsers(Client $client): array
    {
        $url = "{$this->baseUrl}/workspaces/{$client->clockify_workspace_id}/users";

        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
        ])->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("Failed to fetch workspace users: " . $response->body());
    }


    /**
     * Retrieves the summary report for a specified client from the Clockify API.
     *
     * @param Client $client The client instance containing identifiers for the Clockify workspace and client.
     * @return array The decoded JSON response containing the summary report data.
     *
     * @throws \Exception If the API request fails or does not return a successful response.
     */
    public function getSummaryReport(Client $client): array
    {
        $url = "{$this->reportsBaseUrl}/workspaces/{$client->clockify_workspace_id}/reports/summary";

        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'dateRangeStart' => now()->startOfMonth()->utc()->format('Y-m-d\TH:i:s.000\Z'),
            'dateRangeEnd'   => now()->endOfMonth()->utc()->format('Y-m-d\TH:i:s.999\Z'),
            'summaryFilter'  => [
                'groups' => ['PROJECT'],
            ],
            'clients' => [
                'ids' => [$client->clockify_client_id],
            ],
        ]);


        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("Failed to fetch summary report: " . $response->body());
    }

    /**
     * Fetches the detailed report for a specified client from the Clockify API.
     *
     * @param Client $client The client instance containing identifiers for the Clockify workspace and client.
     * @param int $page The page number of the detailed report to retrieve.
     * @param int $pageSize The number of records per page in the detailed report.
     * @return array The decoded JSON response containing the detailed report data.
     *
     * @throws \Exception If the API request fails or does not return a successful response.
     */
    public function getDetailedReport(Client $client, int $page = 1, int $pageSize = 50): array
    {
        $url = "https://reports.api.clockify.me/v1/workspaces/{$client->clockify_workspace_id}/reports/detailed";

        $response = Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($url, [
            'dateRangeStart' => now()->startOfMonth()->utc()->format('Y-m-d\TH:i:s.000\Z'),
            'dateRangeEnd'   => now()->endOfMonth()->utc()->format('Y-m-d\TH:i:s.999\Z'),
            'detailedFilter' => [
                'page' => $page,
                'pageSize' => $pageSize,
            ],
            'clients' => [
                'ids' => [$client->clockify_client_id],
            ],
        ]);

        if (! $response->successful()) {
            throw new \Exception("Failed to fetch detailed report: " . $response->body());
        }

        return $response->json();
    }

}