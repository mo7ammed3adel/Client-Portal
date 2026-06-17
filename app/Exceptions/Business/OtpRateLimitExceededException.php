<?php

namespace App\Exceptions\Business;

use Symfony\Component\HttpKernel\Exception\HttpException;

class OtpRateLimitExceededException extends HttpException
{
    public function __construct(string $message = 'تم تجاوز عدد محاولات كود التحقق. حاول مرة أخرى لاحقاً.')
    {
        parent::__construct(429, $message);
    }
}
