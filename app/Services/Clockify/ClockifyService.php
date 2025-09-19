<?php

namespace App\Services\Clockify;

use App\Models\Client;
use Illuminate\Support\Facades\Http;

class ClockifyService
{
    private string $apiKey = '';
    private string $baseUrl = 'https://api.clockify.me/api/v1';

    public function __construct()
    {
        $this->apiKey = config('services.clockify.api_key');
    }

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

}