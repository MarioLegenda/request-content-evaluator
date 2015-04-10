<?php


namespace RCE\Filters\Contracts;

interface MutatorInterface 
{
	function mutate(array &$toMutate);
}