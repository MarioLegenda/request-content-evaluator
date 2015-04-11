<?php

namespace RCE\Listeners;

abstract class AbstractListener
{
	protected $closure;

	public function __construct(\Closure $closure) {
		$this->closure = $closure;
	}
}