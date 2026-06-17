<?php

namespace App\Services\Sms;

use App\Contracts\Services\SmsServiceContract;
use Illuminate\Support\Facades\Log;

class LogSmsService implements SmsServiceContract
{
    public function send(string $phone, string $message): bool
    {
        Log::channel('otp')->info('SMS sent', [
            'phone' => $phone,
            'message' => $message,
            'timestamp' => now()->toDateTimeString(),
        ]);

        return true;
    }

    public function sendOtp(string $phone, string $otp, string $context = 'verification'): bool
    {
        $message = $this->buildOtpMessage($otp, $context);

        Log::channel('otp')->info('OTP SMS sent', [
            'phone' => $phone,
            'otp' => $otp,
            'context' => $context,
            'message' => $message,
            'timestamp' => now()->toDateTimeString(),
        ]);

        return true;
    }

    private function buildOtpMessage(string $otp, string $context): string
    {
        $appName = config('app.name');

        return match ($context) {
            'registration' => "{$appName}: Your registration code is {$otp}. Valid for 5 minutes.",
            'login' => "{$appName}: Your login code is {$otp}. Valid for 5 minutes.",
            default => "{$appName}: Your verification code is {$otp}. Valid for 5 minutes.",
        };
    }
}
