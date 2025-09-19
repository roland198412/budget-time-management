<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Project;
use App\Services\Clockify\ClockifyService;
use Illuminate\Console\Command;

class PopulateClientClockifyProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clockify:populate-client-clockify-projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command pulls all clockify projects for a client and populates the projects database table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching clients');

        $service = new ClockifyService();

        Client::all()->each(function (Client $client) use ($service) {
                $this->info('Fetching projects for client: ' . $client->name);

                $projects = $service->getProjectsByClient($client);

                if (!empty($projects)) {
                    foreach ($projects as $project) {
                        $projectModel = Project::updateOrCreate([
                            'clockify_project_id' => $project['id'],
                        ],
                        [
                            'name' => $project['name'],
                            'color' => $project['color'],
                            'clockify_project_id' => $project['id'],
                            'client_id' => $client->id,
                        ]);

                        if ($projectModel->wasRecentlyCreated) {
                            $this->info('Created project: ' . $project['name'] . ' for client: ' . $client->name);
                        } else {
                            $this->info('Updated project: ' . $project['name'] . ' for client: ' . $client->name);
                        }
                    }
                }
        });
    }
}
