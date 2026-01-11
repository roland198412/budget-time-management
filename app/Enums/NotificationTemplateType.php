<?php

namespace App\Enums;

enum NotificationTemplateType: string
{
    case WEEKLY_TIMESHEET_SUBMITTED_POSITIVE_BALANCE = 'weekly_timesheet_submitted_positive_balance';
    case WEEKLY_TIMESHEET_SUBMITTED_NEGATIVE_BALANCE = 'weekly_timesheet_submitted_negative_balance';
}
