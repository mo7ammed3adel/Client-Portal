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
            'registration' => "{$appName}: كود إنشاء الحساب هو {$otp}. صالح لمدة 5 دقائق.",
            'login' => "{$appName}: كود تسجيل الدخول هو {$otp}. صالح لمدة 5 دقائق.",
            default => "{$appName}: كود التحقق هو {$otp}. صالح لمدة 5 دقائق.",
        };
    }
}
