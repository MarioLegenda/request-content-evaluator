<?php

namespace RCE\Builder;


use RCE\Builder\Contracts\BuilderInterface;
use RCE\Exceptions\RCEException;
use RCE\Expression\Exceptions\ExpressionFailedException;
use RCE\Expression\Expression;
use RCE\Listeners\ErrorListener;

class Builder implements BuilderInterface
{
    private $content = array();
    private $listeners = array();
    private $expressions = array();

    public function __construct(array $content) {
        $this->content = $content;

        $this->listeners['error-listener'] = new ErrorListener(function($key, $message) {
            return array(
                'key' => $key,
                'value' => $message
            ); 
        });
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
            if( ! $expr->evaluate($this->content)) {
                return false;
            }
        }

        var_dump($this->listeners['error-listener']->getErrors());
        die();
        return true;
    }

    public function getContent() {
        return $this->content;
    }

    public function getErrors() {
        return $this->listeners['error-listener'];
    }
} 