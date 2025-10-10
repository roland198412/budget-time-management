<?php

namespace App\Notifications;

use App\Exports\TimeSheetExport;
use App\Helpers\BucketHelper;
use App\Models\{Client, NotificationTemplate};
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;

class TimeSheetNotification extends Notification
{
    use Queueable;

    private array $contactNames;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Carbon $from, private Carbon $to, private Client $client, private bool $bucketProjectsOnly = false, array $contactNames = [])
    {
        $this->contactNames = $contactNames;
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
        $greetingNames = implode(' / ', $this->contactNames);
        $greeting = 'Hi ' . $greetingNames;

        // Generate Excel in memory
        $excelData = Excel::raw(new TimeSheetExport($this->from, $this->to, $this->client, $this->bucketProjectsOnly), \Maatwebsite\Excel\Excel::XLSX);

        $mailMessage = NotificationTemplate::find(1);

        // If both are in the same month & year, avoid repetition
        if ($this->from->format('F Y') === $this->to->format('F Y')) {
            $dateRange = $this->from->day . ' tot ' . $this->to->day . ' ' . $this->to->translatedFormat('F Y');
        } else {
            // Different month/year -> show full dates
            $dateRange = $this->from->translatedFormat('d F Y') . ' tot ' . $this->to->translatedFormat('d F Y');
        }

        $mailMessage->content = str_replace('{{bucket_available_hours}}', BucketHelper::bucketRemainingHours($this->client), $mailMessage->content);
        $mailMessage->content = str_replace('{{week_date_range_afr}}', $dateRange, $mailMessage->content);

        return (new MailMessage())
            ->greeting($greeting)
            ->subject(str_replace('{{week_date_range_afr}}', $dateRange, $mailMessage->subject))
            ->line(new HtmlString(nl2br($mailMessage->content)))
            ->attachData($excelData, 'timesheet_report_' . $this->from->format('Y-m-d') . '_to_' . $this->to->format('Y-m-d') . '.xlsx', [
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
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
