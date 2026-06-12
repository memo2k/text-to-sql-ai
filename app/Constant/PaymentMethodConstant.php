<?php

namespace App\Constant;

class PaymentMethodConstant
{
    public const CREDIT_CARD = 'credit_card';

    public const PAYPAL = 'paypal';

    public const APPLE_PAY = 'apple_pay';

    public const GOOGLE_PAY = 'google_pay';

    public const BANK_TRANSFER = 'bank_transfer';

    public const ALL = [
        self::CREDIT_CARD,
        self::PAYPAL,
        self::APPLE_PAY,
        self::GOOGLE_PAY,
        self::BANK_TRANSFER,
    ];

    public const LABELS = [
        self::CREDIT_CARD => 'Credit Card',
        self::PAYPAL => 'PayPal',
        self::APPLE_PAY => 'Apple Pay',
        self::GOOGLE_PAY => 'Google Pay',
        self::BANK_TRANSFER => 'Bank Transfer',
    ];

    public static function label(string $method): string
    {
        return self::LABELS[$method] ?? $method;
    }
}
