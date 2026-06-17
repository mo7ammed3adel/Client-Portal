<?php

namespace App\Exceptions\Business;

use Symfony\Component\HttpKernel\Exception\HttpException;

class OtpRateLimitExceededException extends HttpException
{
    public function __construct(string $message = 'Too many OTP attempts. Please try again later.')
    {
        parent::__construct(429, $message);
    }
}
