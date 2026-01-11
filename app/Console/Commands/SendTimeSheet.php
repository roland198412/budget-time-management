<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

use App\Notifications\TimeSheetNotification;
use Carbon\Carbon;

class SendTimeSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Added optional parameters: start, end, weekly, lastweek, and client
     */
    protected $signature = 'app:send-time-sheet 
                            {--start= : Start date (YYYY-MM-DD) for custom range} 
                            {--end= : End date (YYYY-MM-DD) for custom range} 
                            {--weekly : Force sending weekly report} 
                            {--lastweek : Send report for last week (Monday to Sunday)} 
                            {--bucket : Only show time entries for Bucket type projects} 
                            {--client= : Client ID to filter timesheets}';

    protected $description = 'Send weekly or custom timesheet to users filtered by client (or all clients if not specified)';

    public function handle()
    {
        $startDate = $this->option('start');
        $endDate = $this->option('end');
        $isWeekly = $this->option('weekly');
        $isLastWeek = $this->option('lastweek');
        $clientId = $this->option('client');
        $bucketProjectsOnly = $this->option('bucket');

        // Determine date range
        if ($isLastWeek) {
            $start = Carbon::now()->subWeek()->startOfWeek();
            $end = Carbon::now()->subWeek()->endOfWeek();
            $this->info("Generating timesheet for last week: {$start->toDateString()} - {$end->toDateString()}");
        } elseif ($isWeekly || (!$startDate && !$endDate)) {
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
            $this->info("Generating weekly timesheet: {$start->toDateString()} - {$end->toDateString()}");
        } elseif ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            $this->info("Generating timesheet for custom range: {$start->toDateString()} - {$end->toDateString()}");
        } else {
            $this->error('You must provide both --start and --end for a custom range or use --weekly or --lastweek for a report.');

            return 1;
        }

        // Get clients to process
        $clients = $clientId ? Client::where('id', $clientId)->get() : Client::all();

        if ($clients->isEmpty()) {
            $this->error('No clients found.');

            return 1;
        }

        $this->info("Processing " . $clients->count() . " client(s)...");

        foreach ($clients as $client) {
            $contacts = $client->contacts;
            $emails = $contacts->pluck('email')->toArray();
            $names = $contacts->pluck('firstname')->toArray();

            if (empty($emails)) {
                $this->warn("No contacts found for client ID {$client->id} ({$client->name}). Skipping...");
                continue;
            }

            Notification::route('mail', $emails)
                ->notify(new TimeSheetNotification($start, $end, $client, $bucketProjectsOnly, $names));

            $this->info("Timesheet sent successfully to all contacts for client ID {$client->id} ({$client->name})");
        }

        $this->info("All timesheets sent successfully!");

        return 0;
    }
}
