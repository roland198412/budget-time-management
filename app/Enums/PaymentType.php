<?php

namespace App\Enums;

enum PaymentType: string
{
    case INVOICE_PAYMENT = "Invoice Payment";
    case HOURS_WORKED = "Hours Worked";
    case COMMISSION = "Commission";
}
