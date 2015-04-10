<?php

namespace RCE\Expression\Exceptions;


class ExpressionFailedException extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
    }
} 