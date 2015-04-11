<?php

namespace RCE\Listeners;

class ErrorListener extends AbstractListener
{
	private $errors = array();

	public function call($key, $message) {
		$error = $this->closure->__invoke($key, $message);
		$this->errors[$error['key']] = $error['value'];
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