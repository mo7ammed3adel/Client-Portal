<?php

namespace App\Providers;

use App\Contracts\Services\SmsServiceContract;
use App\Services\Sms\LogSmsService;
use App\Services\Sms\TwilioSmsService;
use App\Services\Sms\VonageSmsService;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SmsServiceContract::class, function () {
            return match (config('services.sms.driver', 'log')) {
                'vonage' => new VonageSmsService(),
                'twilio' => new TwilioSmsService(),
                default => new LogSmsService(),
            };
        });
    }
}
