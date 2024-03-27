<?php

declare(strict_types=1);

use Garanaw\LaravelNumeral\Casts\AsNumeral;
use Garanaw\LaravelNumeral\Support\Number;
use Garanaw\LaravelNumeral\Support\Numeral;
use Illuminate\Database\Eloquent\Model;

describe(AsNumeral::class, function () {
    test('DirtyOnCastedNumeral', function () {
        $model = new EloquentModelCastingStub;
        $model->setRawAttributes([
            'asNumeralAttribute' => 123,
        ]);
        $model->syncOriginal();

        $this->assertInstanceOf(Numeral::class, $model->asNumeralAttribute);
        $this->assertFalse($model->isDirty('asNumeralAttribute'));

        $model->asNumeralAttribute = Number::of(123);
        $this->assertFalse($model->isDirty('asNumeralAttribute'));

        $model->asNumeralAttribute = Number::of(456);
        $this->assertTrue($model->isDirty('asNumeralAttribute'));
    });
});

class EloquentModelCastingStub extends Model
{
    protected function casts(): array
    {
        return [
            'asNumeralAttribute' => AsNumeral::class,
        ];
    }

    public function jsonAttributeValue()
    {
        return $this->attributes['jsonAttribute'];
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
