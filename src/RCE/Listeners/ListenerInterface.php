<?php

namespace RCE\Listeners;

interface ListenerInterface 
{
	function addListener($key, AbstractListener $listener);
}