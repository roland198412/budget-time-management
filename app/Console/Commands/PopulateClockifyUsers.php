<?php

namespace App\Console\Commands;

use App\Models\{Client, ClockifyUsers};
use App\Services\Clockify\ClockifyService;
use Illuminate\Console\Command;

class PopulateClockifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-clockify-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to pull all Clockify users and populate the clockify users database table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(__('Fetching clients'));

        $service = new ClockifyService();

        Client::all()->each(function (Client $client) use ($service) {
            $this->info(__('Fetching clockify users for client: ') . $client->name);

            $clockifyUsers = $service->getClientUsers($client);

            if (!empty($clockifyUsers)) {
                foreach ($clockifyUsers as $clockifyUser) {
                    $clockifyUserModel = ClockifyUsers::updateOrCreate(
                        [
                            'clockify_user_id' => $clockifyUser['id'],
                        ],
                        [
                            'name' => $clockifyUser['name'],
                            'email' => $clockifyUser['email'],
                            'clockify_user_id' => $clockifyUser['id'],
                        ]
                    );

                    if ($clockifyUserModel->wasRecentlyCreated) {
                        $this->info(sprintf("%s%s <%s>", __('Created clockify user: '), $clockifyUserModel['name'], $clockifyUserModel['email']));
                    } else {
                        $this->info(sprintf("%s%s <%s>", __('Updated clockify user: '), $clockifyUserModel['name'], $clockifyUserModel['email']));
                    }
                }
            }
        });
    }
}
