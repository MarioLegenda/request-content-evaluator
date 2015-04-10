<?php

namespace Tests;

use RCE\Builder\Builder;
use RCE\ContentEval;
use RCE\Filters\BeString;
use RCE\Filters\Exist;

class RCETest extends \PHPUnit_Framework_TestCase
{
    private $_testSupport;

    public function __construct() {
        $this->_testSupport = new TestSupport();
    }

    public function testBuilder() {
        $builder = new Builder($this->_testSupport->getExample('basic'));

        $builder->build(
            $builder->expr()->hasTo(new Exist('name'), new BeString('name')),
            $builder->expr()->hasTo(new Exist('lastname'), new BeString('name')),
            $builder->expr()->hasTo(new Exist('age'))
        );

        $this->assertTrue(ContentEval::builder($builder)->isValid(),
            'RCETest::testBuilder()-> ContentEval::isValid() returned false but had to return true');
    }


} 