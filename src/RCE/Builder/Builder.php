<?php

namespace RCE\Builder;


use RCE\Builder\Contracts\BuilderInterface;
use RCE\Exceptions\RCEException;
use RCE\Expression\Exceptions\ExpressionFailedException;
use RCE\Expression\Expression;
use RCE\Listeners\Listeners\ErrorListener;

class Builder implements BuilderInterface
{
    private $content = array();
    private $expressions = array();
    private $listeners = null;

    public function __construct(array $content, array $listeners = null) {
        $this->content = $content;

        $this->listeners['error-listener'] = new ErrorListener();
    }

    public function build() {
        $expressions = func_get_args();

        foreach ($expressions as $expr) {
            if (!$expr instanceof Expression) {
                throw new RCEException('RCEException: RCE\Builder::build() has to expect Expression. Invalid type given');
            }
        }

        $this->expressions = $expressions;
    }

    public function expr() {
        return new Expression($this->listeners);
    }

    public function evaluate() {
        foreach($this->expressions as $expr) {
            $expr->evaluate($this->content);
        }

        $errors = $this->listeners['error-listener']->getErrors();

        return empty($errors);
    }

    public function getContent() {
        return $this->content;
    }

    public function getErrors() {
        return $this->listeners['error-listener'];
    }
} 