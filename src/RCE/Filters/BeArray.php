<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 8.4.2015.
 * Time: 10:56
 */

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
} 