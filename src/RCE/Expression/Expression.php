<?php

namespace RCE\Expression;


use RCE\Exceptions\RCEException;
use RCE\Expression\Exceptions\ExpressionFailedException;
use RCE\Filters\Contracts\FilterInterface;
use RCE\Filters\Contracts\MutatorInterface;

class Expression
{
    private $filters = array();

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
            if($filter instanceof MutatorInterface) {
                $filter->mutate($content);
                return true;
            }

            if( ! $filter->evaluate($content)) {
                return false;
            }
        }

        return true;
    }
} 