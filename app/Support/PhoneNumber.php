<?php

namespace App\Support;

class PhoneNumber
{
    public static function toE164(string $phone): string
    {
        $phone = preg_replace('/[\s\-\.\(\)]+/', '', $phone);

        if (str_starts_with($phone, '+20')) {
            return $phone;
        }

        if (str_starts_with($phone, '0020')) {
            return '+'.substr($phone, 2);
        }

        if (str_starts_with($phone, '20') && strlen($phone) === 12) {
            return '+'.$phone;
        }

        if (str_starts_with($phone, '0') && strlen($phone) === 11) {
            return '+2'.$phone;
        }

        return '+'.ltrim($phone, '+');
    }

    public static function mask(string $phone): string
    {
        $length = strlen($phone);

        if ($length <= 4) {
            return str_repeat('*', $length);
        }

        $visiblePrefix = min(4, (int) floor($length * 0.3));
        $visibleSuffix = min(4, (int) floor($length * 0.3));
        $maskedLength = $length - $visiblePrefix - $visibleSuffix;

        if ($maskedLength <= 0) {
            return $phone;
        }

        return substr($phone, 0, $visiblePrefix)
            .str_repeat('*', $maskedLength)
            .substr($phone, -$visibleSuffix);
    }
}
