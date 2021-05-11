<?php

namespace App\Exceptions;

use RuntimeException;

class ApiErrorException extends RuntimeException
{
    protected $code;
    protected $message;

    /**
     *
     *
     * @param int $code
     * @param mixed $message
     */
    public function __construct(?int $code = 99, $message = null)
    {
        $this->code = $code;
        $this->message = $message;
    }
}
