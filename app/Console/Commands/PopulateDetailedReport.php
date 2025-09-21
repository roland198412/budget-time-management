<?php

namespace App\Console\Commands;

use App\Models\{Client, TimeEntry};
use App\Services\Clockify\ClockifyService;
use Illuminate\Console\Command;

class PopulateDetailedReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clockify:populate-detailed-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to pull detailed time entries from Clockify and populate the time_entries database table.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(__('Fetching clients'));

        $service = new ClockifyService();

        Client::all()->each(function (Client $client) use ($service) {
            $this->info(__('Fetching detailed report for client: ') . $client->name);

            try {
                $page = 1;
                do {
                    $detailedReport = $service->getDetailedReport($client, $page);
                    $timeEntries = $detailedReport['timeentries'] ?? [];

                    if (!empty($timeEntries)) {
                        foreach ($timeEntries as $entry) {
                            $timeEntryModel = TimeEntry::updateOrCreate(
                                [
                                    'clockify_time_entry_id' => $entry['_id'],
                                ],
                                [
                                    'clockify_time_entry_id' => $entry['_id'],
                                    'description' => $entry['description'] ?? null,
                                    'clockify_user_id' => $entry['userId'],
                                    'time_interval_start' => $entry['timeInterval']['start'],
                                    'time_interval_end' => $entry['timeInterval']['end'],
                                    'duration' => $entry['timeInterval']['duration'],
                                    'billable' => $entry['billable'] ?? false,
                                    'clockify_project_id' => $entry['projectId'],
                                    'clockify_task_id' => $entry['taskId'] ?? null,
                                    'tag_ids' => $entry['tagIds'] ?? null,
                                    'approval_request_id' => $entry['approvalRequestId'] ?? null,
                                    'type' => $entry['type'] ?? 'REGULAR',
                                    'is_locked' => $entry['isLocked'] ?? false,
                                    'currency' => $entry['currency'] ?? 'USD',
                                    'amount' => $entry['amount'] ?? null,
                                    'rate' => $entry['rate'] ?? null,
                                    'earned_amount' => $entry['earnedAmount'] ?? null,
                                    'earned_rate' => $entry['earnedRate'] ?? null,
                                    'cost_amount' => $entry['costAmount'] ?? null,
                                    'cost_rate' => $entry['costRate'] ?? null,
                                    'project_name' => $entry['projectName'] ?? null,
                                    'project_color' => $entry['projectColor'] ?? null,
                                    'client_name' => $entry['clientName'] ?? null,
                                    'clockify_client_id' => $entry['clientId'] ?? null,
                                    'task_name' => $entry['taskName'] ?? null,
                                    'user_name' => $entry['userName'] ?? null,
                                    'user_email' => $entry['userEmail'] ?? null,
                                ]
                            );

                            if ($timeEntryModel->wasRecentlyCreated) {
                                $this->info(sprintf("%s%s", __('Created time entry: '), $timeEntryModel['description'] ?? 'No description'));
                            } else {
                                $this->info(sprintf("%s%s", __('Updated time entry: '), $timeEntryModel['description'] ?? 'No description'));
                            }
                        }
                    }

                    $page++;
                } while (count($timeEntries) == 50); // Continue if we got a full page

            } catch (\Exception $e) {
                $this->error(__('Error fetching detailed report for client: ') . $client->name . ' - ' . $e->getMessage());
            }
        });
    }
}
