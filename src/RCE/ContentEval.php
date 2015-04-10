<?php

namespace RCE;

use RCE\Builder\Contracts\BuilderInterface;

class ContentEval
{
    private $builder;

    private static $instance;

    private function __construct() {

    }

    private static function init() {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new self();
    }

    public static function builder(BuilderInterface $builder) {
        self::init();

        self::$instance->builder = $builder;

        return self::$instance;
    }

    public function isValid() {
        return $this->builder->evaluate();
    }
} 