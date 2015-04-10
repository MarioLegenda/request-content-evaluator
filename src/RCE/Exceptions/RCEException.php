<?php

namespace RCE\Exceptions;

class RCEException extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
    }
} 