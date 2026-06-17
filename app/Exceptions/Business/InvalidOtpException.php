<?php

namespace App\Exceptions\Business;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidOtpException extends HttpException
{
    public function __construct(string $message = 'Invalid OTP code.')
    {
        parent::__construct(422, $message);
    }
}
