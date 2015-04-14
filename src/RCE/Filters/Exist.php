<?php

namespace RCE\Filters;


use RCE\Filters\Contracts\FilterInterface;

class Exist implements FilterInterface
{
    private $key;

    public function __construct($key) {
        $this->key = $key;
    }

    public function evaluate(array $content) {
        if( ! array_key_exists($this->key, $content)) {
            return false;
        }

        return true;
    }

    public function getKey() {
        return $this->key;
    }
} 