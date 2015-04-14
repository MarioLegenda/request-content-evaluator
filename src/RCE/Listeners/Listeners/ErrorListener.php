<?php

namespace RCE\Listeners\Listeners;

use RCE\Filters\Contracts\FilterInterface;

class ErrorListener extends AbstractListener
{
	private $errors = array();

    public function __construct() {
        $this->callback = function(FilterInterface $filter) {
            $key = $filter->getKey();

            $key = (is_array($key)) ? implode($key, '-') : $key;

            $this->setError($key, get_class($filter) . ' failed for this key in array');
        };
    }

    public function callback(FilterInterface $filter) {
        $this->callback->__invoke($filter);
    }

    public function setError($key, $error) {
        $this->errors[$key][] = $error;
    }

	public function hasError($key) {
		return array_key_exists($key, $this->errors);
	}

	public function getError($key) {
		if( ! $this->hasError($key)) {
			return null;
		}

		return $this->errors[$key];
	}

	public function getErrors() {
		return $this->errors;
	}
}