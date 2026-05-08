<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class DataMaskingService
{
    public static function maskEmail(string $email): string
    {
        if (!self::shouldMask()) {
            return $email;
        }

        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return $email;
        }

        $localPart = $parts[0];
        $domain = $parts[1];

        if (strlen($localPart) <= 1) {
            return $localPart . '***@' . $domain;
        }

        $first = substr($localPart, 0, 1);
        $last = substr($localPart, -1);

        return $first . '***' . $last . '@' . $domain;
    }

    public static function maskPhone(string $phone): string
    {
        if (!self::shouldMask()) {
            return $phone;
        }

        $digits = preg_replace('/\D/', '', $phone);

        if (strlen($digits) < 4) {
            return str_repeat('*', strlen($digits));
        }

        $first = substr($digits, 0, 2);
        $last = substr($digits, -2);
        $masked = str_repeat('*', strlen($digits) - 4);

        return $first . $masked . $last;
    }

    public static function maskRecord($record): object
    {
        if (!self::shouldMask()) {
            return $record;
        }

        $record = (object) $record;
        $record->email = self::maskEmail($record->email ?? '');

        if (isset($record->phone)) {
            $record->phone = self::maskPhone($record->phone ?? '');
        }

        return $record;
    }

    private static function shouldMask(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return Auth::user()->role === 'viewer';
    }
}
