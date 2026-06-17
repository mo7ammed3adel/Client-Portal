<?php

namespace App\Services\Sms;

use App\Contracts\Services\SmsServiceContract;
use App\Exceptions\Business\SmsDeliveryException;
use App\Support\PhoneNumber;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VonageSmsService implements SmsServiceContract
{
    private readonly string $apiKey;
    private readonly string $apiSecret;
    private readonly string $from;

    public function __construct()
    {
        $this->apiKey = (string) config('services.sms.vonage.api_key');
        $this->apiSecret = (string) config('services.sms.vonage.api_secret');
        $this->from = (string) config('services.sms.vonage.from', config('app.name'));
    }

    public function send(string $phone, string $message): bool
    {
        try {
            $response = Http::timeout(10)->asForm()->post('https://rest.nexmo.com/sms/json', [
                'api_key' => $this->apiKey,
                'api_secret' => $this->apiSecret,
                'to' => ltrim($phone, '+'),
                'from' => $this->from,
                'text' => $message,
            ]);
        } catch (\Throwable $e) {
            Log::error('Vonage SMS transport failure', [
                'phone' => PhoneNumber::mask($phone),
                'error' => $e->getMessage(),
            ]);
            throw new SmsDeliveryException('vonage', 'transport', $e->getMessage(), $e);
        }

        if ($response->failed()) {
            Log::error('Vonage SMS HTTP error', [
                'phone' => PhoneNumber::mask($phone),
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new SmsDeliveryException('vonage', (string) $response->status(), $response->body() ?: 'Vonage error');
        }

        $data = $response->json();
        $messageStatus = (string) ($data['messages'][0]['status'] ?? '99');

        if ($messageStatus !== '0') {
            $errorText = (string) ($data['messages'][0]['error-text'] ?? 'Unknown error');

            Log::error('Vonage SMS rejected', [
                'phone' => PhoneNumber::mask($phone),
                'status' => $messageStatus,
                'error_text' => $errorText,
            ]);

            throw new SmsDeliveryException('vonage', $messageStatus, $errorText);
        }

        Log::info('Vonage SMS sent', [
            'phone' => PhoneNumber::mask($phone),
            'message_id' => $data['messages'][0]['message-id'] ?? null,
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
            'registration' => "{$appName}: Your registration code is {$otp}. Valid for 5 minutes.",
            'login' => "{$appName}: Your login code is {$otp}. Valid for 5 minutes.",
            default => "{$appName}: Your verification code is {$otp}. Valid for 5 minutes.",
        };
    }
}
