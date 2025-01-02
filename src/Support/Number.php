<?php

namespace Garanaw\LaravelNumeral\Support;

use Illuminate\Support\Traits\Macroable;
use Random\Randomizer;

class Number extends \Illuminate\Support\Number
{
    use Macroable;

    /**
     * Get a new numeral instance for the given value.
     *
     * @param  int|float  $value
     */
    public static function of($value): Numeral
    {
        return new Numeral($value);
    }

    /**
     * Determine if the given value is a number.
     *
     * @param  mixed  $number
     */
    public static function isNumeric($number): bool
    {
        return is_numeric($number);
    }

    /**
     * Determine if the given value is an even number.
     *
     * @param  mixed  $value
     */
    public static function isEven($value): bool
    {
        return $value % 2 === 0;
    }

    /**
     * Determine if the given value is an odd number.
     *
     * @param  mixed  $value
     */
    public static function isOdd($value): bool
    {
        return $value % 2 !== 0;
    }

    /**
     * Determine if the given value is a float.
     *
     * @param  mixed  $value
     */
    public static function isFloat($value): bool
    {
        return self::isNumeric($value) && is_float($value + 0);
    }

    /**
     * Determine if the given value is an integer.
     *
     * @param  mixed  $value
     */
    public static function isInt($value): bool
    {
        return self::isNumeric($value) && is_int($value + 0);
    }

    /**
     * Determine if the given value is a positive number.
     *
     * @param  mixed  $value
     */
    public static function isPositive($value): bool
    {
        return $value > 0;
    }

    /**
     * Determine if the given value is a positive integer.
     *
     * @param  mixed  $value
     */
    public static function isPositiveInt($value): bool
    {
        return self::isInt($value) && self::isPositive($value);
    }

    /**
     * Determine if the given value is a positive float.
     *
     * @param  mixed  $value
     */
    public static function isPositiveFloat($value): bool
    {
        return self::isFloat($value) && self::isPositive($value);
    }

    /**
     * Determine if the given value is a negative number.
     *
     * @param  mixed  $value
     */
    public static function isNegative($value): bool
    {
        return $value < 0;
    }

    /**
     * Determine if the given value is a negative integer.
     *
     * @param  mixed  $value
     */
    public static function isNegativeInt($value): bool
    {
        return self::isInt($value) && self::isNegative($value);
    }

    /**
     * Determine if the given value is a negative float.
     *
     * @param  mixed  $value
     */
    public static function isNegativeFloat($value): bool
    {
        return self::isFloat($value) && self::isNegative($value);
    }

    /**
     * Determine if the given value is zero.
     *
     * @param  mixed  $value
     */
    public static function isZero($value): bool
    {
        return ((int) $value) === 0;
    }

    /**
     * Determine if the given value is between the given min and max values.
     *
     * @param  int|float  $value
     * @param  int|float  $min
     * @param  int|float  $max
     * @return bool
     */
    public static function isBetween($value, $min, $max): bool
    {
        return $value >= $min && $value <= $max;
    }

    /**
     * Determine if the given value is in scientific notation.
     *
     * @param  int|float|string  $value
     * @return bool
     */
    public static function isScientificNotation($value): bool
    {
        return static::isScientificENotation($value);
    }

    /**
     * Determine if the given value is in scientific notation with an 'e' character.
     *
     * @param  int|float|string  $value
     * @return bool
     */
    public static function isScientificENotation($value): bool
    {
        return static::isNumeric($value) && preg_match('/[eE]/', $value) === 1;
    }

    public static function scientificToReal($scientificNotation, int $precision = 10): int|float|string
    {
        if (self::isScientificNotation($scientificNotation) === false) {
            return $scientificNotation;
        }

        return static::format($scientificNotation, $precision);
    }

    /**
     * Counts the length of a numeral.
     *
     * @param  $value
     * @return int|null
     */
    public static function len($value): ?int
    {
        if (self::isNumeric($value) === false) {
            return null;
        }

        return mb_strlen($value);
    }

    /**
     * Returns a random number using the Randomizer class from PHP.
     */
    public static function random(): Numeral
    {
        return new Numeral((new Randomizer())->nextInt());
    }

    /**
     * Returns a random number between the given min and max values.
     */
    public static function randomBetween(int $min, int $max): Numeral
    {
        return new Numeral((new Randomizer())->getInt($min, $max));
    }

    /**
     * Get the greatest common divisor of two numbers.
     */
    public static function gcd(int|float $a, int|float $b): int|float
    {
        if (self::isZero($b)) {
            return $a;
        }

        if (self::isZero($a)) {
            return $b;
        }

        return static::gcd($b, $a % $b);
    }

    /**
     * Get the least common multiple of two numbers.
     */
    public static function lcm(int|float $a, int|float $b): int|float
    {
        return self::isZero($a) || self::isZero($b)
            ? 0
            : abs($a * $b) / static::gcd($a, $b);
    }

    /**
     * Get the factorial of a number.
     */
    public static function factorial(int|float $number): int|float
    {
        if ($number < 0) {
            return 0;
        }

        if ($number === 0) {
            return 1;
        }

        return $number * static::factorial($number - 1);
    }
}
