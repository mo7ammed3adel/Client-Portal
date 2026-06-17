<?php

namespace App\Services\Sms;

use App\Contracts\Services\SmsServiceContract;
use App\Exceptions\Business\SmsDeliveryException;
use App\Support\PhoneNumber;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwilioSmsService implements SmsServiceContract
{
    private readonly string $accountSid;
    private readonly string $authToken;
    private readonly string $from;

    public function __construct()
    {
        $this->accountSid = (string) config('services.sms.twilio.sid');
        $this->authToken = (string) config('services.sms.twilio.token');
        $this->from = (string) config('services.sms.twilio.from');
    }

    public function send(string $phone, string $message): bool
    {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->accountSid}/Messages.json";

        try {
            $response = Http::timeout(10)
                ->withBasicAuth($this->accountSid, $this->authToken)
                ->asForm()
                ->post($url, [
                    'To' => $phone,
                    'From' => $this->from,
                    'Body' => $message,
                ]);
        } catch (\Throwable $e) {
            Log::error('Twilio SMS transport failure', [
                'phone' => PhoneNumber::mask($phone),
                'error' => $e->getMessage(),
            ]);
            throw new SmsDeliveryException('twilio', 'transport', $e->getMessage(), $e);
        }

        if ($response->failed()) {
            $code = (string) ($response->json('code') ?? $response->status());
            $message = (string) ($response->json('message') ?? $response->body() ?? 'تعذر إرسال الرسالة عبر Twilio.');

            Log::error('Twilio SMS HTTP error', [
                'phone' => PhoneNumber::mask($phone),
                'status' => $response->status(),
                'error_code' => $code,
                'error_message' => $message,
            ]);

            throw new SmsDeliveryException('twilio', $code, $message);
        }

        Log::info('Twilio SMS sent', [
            'phone' => PhoneNumber::mask($phone),
            'sid' => $response->json('sid'),
        ]);

        return true;
    }

    public function sendOtp(string $phone, string $otp, string $context = 'verification'): bool
    {
        return $this->send($phone, $this->buildOtpMessage($otp, $context));
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
