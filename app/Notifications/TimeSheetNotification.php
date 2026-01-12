<?php

namespace App\Notifications;

use App\Enums\NotificationTemplateType;
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
//    use Queueable;

    private array $contactNames;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private Carbon $startDate,
        private Carbon $endDate,
        private Client $client,
        private bool $bucketProjectsOnly = false,
        array $contactNames = []
    ) {
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
        $excelData = Excel::raw(
            new TimeSheetExport($this->startDate, $this->endDate, $this->client, $this->bucketProjectsOnly),
            \Maatwebsite\Excel\Excel::XLSX
        );

        $availableBucketHours = BucketHelper::bucketRemainingHours($this->client);

        // Determine template based on bucket balance
        $templateType = $availableBucketHours < 0
            ? NotificationTemplateType::WEEKLY_TIMESHEET_SUBMITTED_NEGATIVE_BALANCE
            : NotificationTemplateType::WEEKLY_TIMESHEET_SUBMITTED_POSITIVE_BALANCE;

        $notificationTemplate = NotificationTemplate::where('template_type', $templateType)
            ->where('client_id', $this->client->id)
            ->first();

        if (!$notificationTemplate) {
            throw new \RuntimeException(
                "Notification template with identifier 'timesheet' not found for client '{$this->client->name}' (ID: {$this->client->id}). " .
                "Please create a notification template with identifier 'timesheet' for this client."
            );
        }

        // If both are in the same month & year, avoid repetition
        if ($this->startDate->format('F Y') === $this->endDate->format('F Y')) {
            $dateRange = $this->startDate->day . ' tot ' . $this->endDate->day . ' ' . $this->endDate->translatedFormat('F Y');
        } else {
            // Different month/year -> show full dates
            $dateRange = $this->startDate->translatedFormat('d F Y') . ' tot ' . $this->endDate->translatedFormat('d F Y');
        }

        $formattedBucketHours = $availableBucketHours < 0
            ? '<span style="color: red; font-weight: bold;">' . $availableBucketHours . '</span>'
            : $availableBucketHours;

        $emailContent = str_replace('{{bucket_available_hours}}', $formattedBucketHours, $notificationTemplate->content);
        $emailContent = str_replace('{{week_date_range_afr}}', $dateRange, $emailContent);
        $emailSubject = str_replace('{{week_date_range_afr}}', $dateRange, $notificationTemplate->subject);

        return (new MailMessage())
            ->greeting($greeting)
            ->subject($emailSubject)
            ->line(new HtmlString(nl2br($emailContent)))
            ->attachData(
                $excelData,
                'timesheet_report_' . $this->startDate->format('Y-m-d') . '_to_' . $this->endDate->format('Y-m-d') . '.xlsx',
                ['mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
            );
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
