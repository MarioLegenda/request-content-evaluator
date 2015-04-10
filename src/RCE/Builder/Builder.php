<?php

namespace RCE\Builder;


use RCE\Builder\Contracts\BuilderInterface;
use RCE\Exceptions\RCEException;
use RCE\Expression\Exceptions\ExpressionFailedException;
use RCE\Expression\Expression;

class Builder implements BuilderInterface
{
    private $content = array();

    private $expressions = array();

    public function __construct(array $content) {
        $this->content = $content;
    }

    public function build() {
        $expressions = func_get_args();

        foreach ($expressions as $expr) {
            if (!$expr instanceof Expression) {
                throw new RCEException('RCEException: Something went wrong internally in the Builder class. Please, contact the creator whitepostmail@gmail.com');
            }
        }

        $this->expressions = $expressions;
    }

    public function expr() {
        return new Expression();
    }

    public function evaluate() {
        foreach($this->expressions as $expr) {
            if( ! $expr->evaluate($this->content)) {
                return false;
            }
        }

        return true;
    }
} 