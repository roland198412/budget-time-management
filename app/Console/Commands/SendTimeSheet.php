<?php

namespace App\Console\Commands;

use App\Models\{Client, User};
use Illuminate\Console\Command;

use App\Notifications\TimeSheetNotification;
use Carbon\Carbon;

class SendTimeSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Added optional parameters: start, end, weekly, and client
     */
    protected $signature = 'app:send-time-sheet 
                            {--start= : Start date (YYYY-MM-DD) for custom range} 
                            {--end= : End date (YYYY-MM-DD) for custom range} 
                            {--weekly : Force sending weekly report} 
                            {--bucket : Only show time entries for Bucket type projects} 
                            {--client= : Client ID to filter timesheets}';

    protected $description = 'Send weekly or custom timesheet to users filtered by client';

    public function handle()
    {
        $startDate = $this->option('start');
        $endDate = $this->option('end');
        $isWeekly = $this->option('weekly');
        $clientId = $this->option('client');
        $bucketProjectsOnly = $this->option('bucket');

        if (!$clientId) {
            $this->error('You must provide a --client ID.');

            return 1;
        }

        // Determine date range
        if ($isWeekly || (!$startDate && !$endDate)) {
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
            $this->info("Generating weekly timesheet: {$start->toDateString()} - {$end->toDateString()}");
        } elseif ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            $this->info("Generating timesheet for custom range: {$start->toDateString()} - {$end->toDateString()}");
        } else {
            $this->error('You must provide both --start and --end for a custom range or use --weekly for weekly report.');

            return 1;
        }

        $users = User::all();
        $client = Client::find($clientId);

        foreach ($users as $user) {
            // Send notification
            $user->notify(new TimeSheetNotification($start, $end, $client, $bucketProjectsOnly));
        }

        $this->info("Timesheets sent successfully for client ID {$clientId}!");
    }
}
