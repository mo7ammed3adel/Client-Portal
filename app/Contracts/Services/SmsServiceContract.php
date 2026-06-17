<?php

namespace App\Contracts\Services;

interface SmsServiceContract
{
    public function send(string $phone, string $message): bool;

    public function sendOtp(string $phone, string $otp, string $context = 'verification'): bool;
}
