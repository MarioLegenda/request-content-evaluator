<?php

namespace RCE\Filters\Contracts;


interface FilterInterface
{
    function evaluate(array $content);
} 