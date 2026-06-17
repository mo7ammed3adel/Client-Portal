<?php

namespace App\Jobs\Sms;

use App\Contracts\Services\SmsServiceContract;
use App\Support\PhoneNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendSmsOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [5, 15, 30, 60, 120];
    }

    public function __construct(
        public readonly string $phone,
        public readonly string $otp,
        public readonly string $context = 'verification'
    ) {
        $this->onQueue('notifications');
    }

    public function handle(SmsServiceContract $smsService): void
    {
        $smsService->sendOtp($this->phone, $this->otp, $this->context);
    }

    public function failed(Throwable $exception): void
    {
        Log::channel('otp')->error('SendSmsOtpJob permanently failed', [
            'phone' => PhoneNumber::mask($this->phone),
            'context' => $this->context,
            'attempts' => $this->attempts(),
            'error' => $exception->getMessage(),
        ]);
    }
}
