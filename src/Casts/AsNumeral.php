<?php

namespace Garanaw\LaravelNumeral\Casts;

use Garanaw\LaravelNumeral\Support\Number;
use Garanaw\LaravelNumeral\Support\Numeral;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsNumeral implements Castable
{
    /**
     * Get the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return \Illuminate\Contracts\Database\Eloquent\CastsAttributes<\Illuminate\Support\Numeral, int>
     */
    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes
        {
            public function get($model, $key, $value, $attributes)
            {
                return isset($value) ? Number::of($value) : null;
            }

            public function set($model, $key, $value, $attributes)
            {
                if (! isset($value)) {
                    return null;
                }

                if (Number::isNumeric($value)) {
                    return $value;
                }

                if ($value instanceof Numeral) {
                    return $value->value();
                }

                return null;
            }
        };
    }
}
