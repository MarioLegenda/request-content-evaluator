<?php

namespace Tests;


class TestSupport
{
    private $_exampleContent;

    public function __construct() {
        $content = array(
            'basic' => array(
                'name' => 'Mario',
                'lastname' => 'Škrlec',
                'age' => 28,
                'birth_date' => array(
                    'day' =>  18,
                    'month' => 06,
                    'year' => 1986
                )
            ),
            'complex' => array(
                'complex-exp1' => array(
                    'filterType' => 'personal-filter',
                    'key' => 'personal',
                    'personal' => array(
                        'name' => 'Mario',
                        'lastname' => 'Škrlec'
                    )
                ),
                'complex-exp2' => array(
                    'filterType' => 'username-filter',
                    'key' => 'username',
                    'username' => 'whitepostmail@gmail.com'
                )
            )
        );

        $contentIt = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($content), \RecursiveIteratorIterator::CHILD_FIRST);

        $this->_exampleContent = $contentIt;
    }

    public function getExample($contentType) {
        while($this->_exampleContent->valid()) {
            $key = $this->_exampleContent->key();
            if($key === $contentType) {
                return $this->_exampleContent->current();
            }

            $this->_exampleContent->next();
        }
    }
} 