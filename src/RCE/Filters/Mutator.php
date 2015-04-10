<?php

namespace RCE\Filters;

use RCE\Filters\BeInteger;
use RCE\Filters\Contracts\FilterInterface;
use RCE\Filters\Contracts\MutatorInterface;
use RCE\Exceptions\RCEException;

class Mutator implements MutatorInterface
{
	private $closure;
	private $key;

    public function __construct($key, \Closure $closure) {
    	$this->key = $key;
    	$this->closure = $closure;
    }

    public function mutate(array &$content) {
    	if( ! array_key_exists($this->key, $content)) {
    		throw new RCEException('Content does not exists with key ' . $this->key . '. Use Exists() first');
    	}

    	$param = $content[$this->key];
    	$content[$this->key] = $this->closure->__invoke($param);
    }
} 