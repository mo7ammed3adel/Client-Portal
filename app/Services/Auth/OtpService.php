<?php

namespace App\Services\Auth;

use App\Exceptions\Business\InvalidOtpException;
use App\Exceptions\Business\OtpRateLimitExceededException;
use App\Jobs\Sms\SendSmsOtpJob;
use App\Support\PhoneNumber;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class OtpService
{
    public function __construct(
        private readonly CacheRepository $cache
    ) {}

    public function generateAndStore(string $phone, string $context = 'verification'): string
    {
        $normalizedPhone = PhoneNumber::toE164($phone);
        $attemptKey = $this->attemptKey($normalizedPhone, $context);
        $attempts = $this->cache->get($attemptKey, 0);

        if ($attempts >= $this->maxAttempts()) {
            throw new OtpRateLimitExceededException();
        }

        $otp = $this->fixedOtp()
            ?? str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        $this->cache->put($this->otpKey($normalizedPhone, $context), hash('sha256', $otp), $this->otpTtl());

        SendSmsOtpJob::dispatch($normalizedPhone, $otp, $context);

        return $otp;
    }

    public function verify(string $phone, string $otp, string $context = 'verification'): bool
    {
        $normalizedPhone = PhoneNumber::toE164($phone);
        $attemptKey = $this->attemptKey($normalizedPhone, $context);
        $attempts = $this->cache->get($attemptKey, 0);

        if ($attempts >= $this->maxAttempts()) {
            throw new OtpRateLimitExceededException();
        }

        $otpKey = $this->otpKey($normalizedPhone, $context);
        $storedHash = $this->cache->get($otpKey);

        if (! $storedHash) {
            throw new InvalidOtpException('انتهت صلاحية كود التحقق أو لم يعد موجوداً.');
        }

        if (! hash_equals($storedHash, hash('sha256', $otp))) {
            $this->cache->put($attemptKey, $attempts + 1, $this->otpTtl());
            throw new InvalidOtpException('كود التحقق غير صحيح.');
        }

        $this->cache->forget($otpKey);
        $this->cache->forget($attemptKey);

        return true;
    }

    private function otpTtl(): int
    {
        return (int) config('services.sms.otp_ttl_seconds', 300);
    }

    private function maxAttempts(): int
    {
        return (int) config('services.sms.otp_max_attempts', 3);
    }

    private function fixedOtp(): ?string
    {
        $otp = config('services.sms.otp_fixed_code');

        if (! is_string($otp) || ! preg_match('/^\d{6}$/', $otp)) {
            return null;
        }

        return $otp;
    }

    private function otpKey(string $phone, string $context): string
    {
        return "otp:{$context}:{$phone}";
    }

    private function attemptKey(string $phone, string $context): string
    {
        return "otp:{$context}:attempts:{$phone}";
    }
}
