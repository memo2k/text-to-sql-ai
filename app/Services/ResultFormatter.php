<?php

namespace App\Services;

use App\Constant\PaymentMethodConstant;

class ResultFormatter
{
    public static function cell(string $column, mixed $value): string
    {
        if ($column === 'payment_method' && $value !== null && $value !== '') {
            return PaymentMethodConstant::label((string) $value);
        }

        return (string) ($value ?? '');
    }
}
