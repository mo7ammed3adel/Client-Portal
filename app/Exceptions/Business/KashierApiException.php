<?php

namespace App\Exceptions\Business;

use Symfony\Component\HttpKernel\Exception\HttpException;

class KashierApiException extends HttpException
{
    public function __construct(
        public readonly string $kashierMessage,
        string $message = 'حدث خطأ أثناء الاتصال ببوابة كاشير.'
    ) {
        parent::__construct(502, $message);
    }
}
