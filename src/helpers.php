<?php

use Garanaw\LaravelNumeral\Support\Number;

if (! function_exists('num')) {
    /**
     * Get a new Numeral object from the given number.
     *
     * @param  int|float|null  $number
     * @return \Illuminate\Support\Numeral|mixed
     */
    function num($number = null)
    {
        if (func_num_args() === 0) {
            return new class
            {
                public function __call($method, $parameters)
                {
                    return Number::$method(...$parameters);
                }

                public function value()
                {
                    return 0;
                }
            };
        }

        return Number::of($number);
    }
}
