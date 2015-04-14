<?php

namespace RCE\Filters;

use RCE\Filters\BeInteger;
use RCE\Filters\Contracts\FilterInterface;
use RCE\Exceptions\RCEException;
use RCE\Listeners\ListenerInterface;
use RCE\Listeners\AbstractListener;

class OptionalExists implements FilterInterface, ListenerInterface
{
	private $keys = array();
	private $listeners = array();

    public function __construct(array $keys) {
    	if(empty($keys)) {
    		throw new RCEException('OptionalExists has to accept at least one argument');
    	}

    	$this->keys = $keys;
    }

    public function addListener($key, AbstractListener $listener) {
    	$this->listeners[$key] = $listener;
    }

    public function evaluate(array $content) {
    	$maximumFailed = count($this->keys);
    	$failed = 0;

    	$existing = array();
    	foreach($this->keys AS $key => $filter) {
    		if( ! $filter instanceof FilterInterface) {
    			throw new RCEException('OptionalExists has to have a key/value pair where value has to be of type FilterInterface for key ' . $key);
    		}

    		if( ! array_key_exists($key, $content)) {
    			$failed++;
    			continue;
    		}

    		$existing[$key] = $filter;
    	}

    	if($failed >= $maximumFailed) {
    		$this->listeners['error-listener']->call('optional-exists', 'Both optional keys does not exist');
    		return false;
    	}

    	foreach($existing as $key => $filter) {
    		if( ! $filter->evaluate($content)) {
    			$this->listeners['error-listener']->call($key, $key . ' has failed to evaluate');
    			return false;
    		}
    	}

    	return true;
    }

    public function getKey() {
        return $this->keys;
    }
} 