<?php

namespace App\Enums;

/**
 * Enum representing the payment status of a bucket.
 */
enum PaymentStatus: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';

    /**
     * Get all values for form dropdowns, etc.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get a human-readable label for the status.
     */
    public function label(): string
    {
        return match($this) {
            self::PAID => 'Paid',
            self::UNPAID => 'Unpaid',
        };
    }
}
