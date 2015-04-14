<?php

namespace Tests;

use RCE\Builder\Builder;
use RCE\ContentEval;
use RCE\Filters\BeString;
use RCE\Filters\BeInteger;
use RCE\Filters\BeArray;
use RCE\Filters\Exist;
use RCE\Filters\Mutator;
use RCE\Filters\OptionalExists;

use RCE\Listeners\ErrorListener;
use RCE\Expression\Expression;

class RCETest extends \PHPUnit_Framework_TestCase
{
    private $_testSupport;

    public function __construct() {
        $this->_testSupport = new TestSupport();
    }

    public function testSimpleBuilder() {
        $builder = new Builder($this->_testSupport->getExample('basic'));

        $builder->build(
            $builder->expr()->hasTo(new Exist('name'), new BeString('name')),
            $builder->expr()->hasTo(new Exist('lastname'), new BeString('lastname')),
            $builder->expr()->hasTo(new Exist('age'), new BeInteger('age')),
            $builder->expr()->hasTo(new Exist('birth_date'), new BeArray('birth_date'), new Mutator('birth_date', function($toMutate) {
                $day = $toMutate['day'];
                $month = $toMutate['month'];
                $year = $toMutate['year'];

                return new \DateTime($day . '.' . $month . '.' . $year);
            }))
        );

        $valid = ContentEval::builder($builder)->isValid();
        $this->assertTrue($valid,
            'RCETest::testSimbleBuilder()-> ContentEval::isValid() returned false but had to return true');
    }

    public function testComplexBuilder() {
        $builder = new Builder($this->_testSupport->getExample('complex-exp1'));

        $builder->build(
            $builder->expr()->hasTo(new Exist('filterType'), new BeString('filterType')),
            $builder->expr()->hasTo(new Exist('key'), new BeString('key')),
            $builder->expr()->hasTo(new OptionalExists(array(
                'username' => new BeString('username'),
                'personal' => new BeArray('personal')
            )))
        );

        $this->assertTrue(ContentEval::builder($builder)->isValid(), 
            'RCETest::testComplexBuilder()-> ContentEval::isValid() returned false but had to return true');
    }


} 