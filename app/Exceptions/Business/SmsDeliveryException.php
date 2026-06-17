<?php

namespace App\Exceptions\Business;

use RuntimeException;
use Throwable;

class SmsDeliveryException extends RuntimeException
{
    public function __construct(
        public readonly string $provider,
        public readonly string $providerCode,
        string $message,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }
}
