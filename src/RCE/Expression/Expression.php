<?php

namespace RCE\Expression;


use RCE\Exceptions\RCEException;
use RCE\Expression\Exceptions\ExpressionFailedException;
use RCE\Filters\Contracts\FilterInterface;
use RCE\Filters\Contracts\MutatorInterface;
use RCE\Listeners\ListenerInterface;

class Expression
{
    private $filters = array();
    private $listeners = array();

    public function __construct(array $listeners) {
        $this->listeners = $listeners;
    }

    public function hasTo() {
        $filters = func_get_args();

        foreach($filters as $filter) {
            if( ! $filter instanceof FilterInterface AND ! $filter instanceof MutatorInterface) {
                throw new RCEException('RCEException: Something went wrong internally in the Builder class. Please, contact the creator whitepostmail@gmail.com');
            }
        }

        $this->filters = $filters;

        return $this;
    }

    public function evaluate(array &$content) {
        foreach($this->filters as $filter) {
            if($filter instanceof FilterInterface) {
                if( ! $filter->evaluate($content)) {
                    foreach($this->listeners as $listener) {
                        $listener->callback($filter);
                    }

                    return false;
                }
            }

            if($filter instanceof MutatorInterface) {
                $filter->mutate($content);
                return true;
            }
        }

        return true;
    }
} 