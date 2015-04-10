<?php

namespace RCE\Filters;


use RCE\Filters\Contracts\FilterInterface;

class BeString implements FilterInterface
{
    private $key;

    public function __construct($key) {
        $this->key = $key;
    }

    public function evaluate(array $content) {
        if( ! is_string($content[$this->key])) {
            return false;
        }

        return true;
    }
} 