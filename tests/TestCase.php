<?php

declare(strict_types=1);

namespace Garanaw\LaravelNumeral\Tests;

use Garanaw\LaravelNumeral\Support\Numeral;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function numeral($value = 0)
    {
        return new Numeral($value);
    }
}