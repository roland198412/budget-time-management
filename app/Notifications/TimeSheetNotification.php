<?php

namespace App\Notifications;

use App\Exports\TimeSheetExport;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;

class TimeSheetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Carbon $from, private Carbon $to, private Client $client, private bool $bucketProjectsOnly = false)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Generate Excel in memory
        $excelData = Excel::raw(new TimeSheetExport($this->from, $this->to, $this->client, $this->bucketProjectsOnly), \Maatwebsite\Excel\Excel::XLSX);

        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->attachData($excelData, 'timesheet_report_' . $this->from->format('Y-m-d') . '_to_' . $this->to->format('Y-m-d') . '.xlsx', [
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
