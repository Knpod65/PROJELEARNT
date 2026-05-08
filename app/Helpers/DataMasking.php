<?php

use App\Services\DataMaskingService;

if (!function_exists('maskEmail')) {
    function maskEmail(string $email): string
    {
        return DataMaskingService::maskEmail($email);
    }
}

if (!function_exists('maskPhone')) {
    function maskPhone(string $phone): string
    {
        return DataMaskingService::maskPhone($phone);
    }
}

if (!function_exists('maskRecord')) {
    function maskRecord($record): object
    {
        return DataMaskingService::maskRecord($record);
    }
}
