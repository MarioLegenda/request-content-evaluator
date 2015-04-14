<?php

namespace RCE\Filters;

use RCE\Filters\BeInteger;
use RCE\Filters\Contracts\FilterInterface;

class BeArray implements FilterInterface
{
	private $key;

    public function __construct($key) {
        $this->key = $key;
    }

    public function evaluate(array $content) {
        if( ! is_array($content[$this->key])) {
            return false;
        }

        return true;
    }

    public function getKey() {
        return $this->key;
    }
} 