<?php

use Garanaw\LaravelNumeral\Support\Numeral;
use Garanaw\LaravelNumeral\Support\Number;

describe(Numeral::class, function () {
    test('num returns a numeral', function () {
        $this->assertInstanceOf(Numeral::class, num(1));
    });

    it('detects even numbers', function () {
        $this->assertTrue($this->numeral(2)->isEven());
        $this->assertFalse($this->numeral(3)->isEven());
    });

    it('detects odd numbers', function () {
        $this->assertTrue($this->numeral(3)->isOdd());
        $this->assertFalse($this->numeral(2)->isOdd());
    });

    it('detects float numbers', function () {
        $this->assertTrue($this->numeral(11.0)->isFloat());
        $this->assertFalse($this->numeral(3)->isFloat());
    });

    it('detects integers', function () {
        $this->assertTrue($this->numeral(3)->isInt());
        $this->assertFalse($this->numeral(11.0)->isInt());
    });

    it('detects positive numbers', function () {
        $this->assertTrue($this->numeral(3)->isPositive());
        $this->assertFalse($this->numeral(-3)->isPositive());
    });

    it('detects positive integers', function () {
        $this->assertTrue($this->numeral(3)->isPositiveInt());
        $this->assertFalse($this->numeral(-3)->isPositiveInt());
        $this->assertFalse($this->numeral(11.0)->isPositiveInt());
    });

    it('detects positive floats', function () {
        $this->assertTrue($this->numeral(11.0)->isPositiveFloat());
        $this->assertFalse($this->numeral(-11.0)->isPositiveFloat());
        $this->assertFalse($this->numeral(3)->isPositiveFloat());
    });

    it('detects negative numbers', function () {
        $this->assertTrue($this->numeral(-3)->isNegative());
        $this->assertFalse($this->numeral(3)->isNegative());
    });

    it('detects negative integer', function () {
        $this->assertTrue($this->numeral(-3)->isNegativeInt());
        $this->assertFalse($this->numeral(3)->isNegativeInt());
        $this->assertFalse($this->numeral(11.0)->isNegativeInt());
    });

    it('detects negative float', function () {
        $this->assertTrue($this->numeral(-11.0)->isNegativeFloat());
        $this->assertFalse($this->numeral(11.0)->isNegativeFloat());
        $this->assertFalse($this->numeral(3)->isNegativeFloat());
    });

    it('detects zero values', function () {
        $this->assertTrue($this->numeral(0)->isZero());
        $this->assertFalse($this->numeral(3)->isZero());
        $this->assertFalse($this->numeral(-3)->isZero());
    });

    it('negates numbers', function () {
        $this->assertSame(-3, $this->numeral(3)->negate()->value());
        $this->assertSame(3, $this->numeral(-3)->negate()->value());

        $this->assertSame(0, $this->numeral(0)->negate()->value());

        $this->assertSame(-11.0, $this->numeral(11.0)->negate()->value());
        $this->assertSame(11.0, $this->numeral(-11.0)->negate()->value());
    });

    it('formats numbers', function () {
        $this->assertSame('0', $this->numeral(0)->format()->value());
        $this->assertSame('0', $this->numeral(0.0)->format()->value());
        $this->assertSame('0', $this->numeral(0.00)->format()->value());
        $this->assertSame('1', $this->numeral(1)->format()->value());
        $this->assertSame('10', $this->numeral(10)->format()->value());
        $this->assertSame('25', $this->numeral(25)->format()->value());
        $this->assertSame('100', $this->numeral(100)->format()->value());
        $this->assertSame('100,000', $this->numeral(100000)->format()->value());
        $this->assertSame('100,000.00', $this->numeral(100000)->format(2)->value());
        $this->assertSame('100,000.12', $this->numeral(100000.123)->format(2)->value());
        $this->assertSame('100,000.123', $this->numeral(100000.1234)->format(maxPrecision: 3)->value());
        $this->assertSame('100,000.124', $this->numeral(100000.1236)->format(maxPrecision: 3)->value());
        $this->assertSame('123,456,789', $this->numeral(123456789)->format()->value());

        $this->assertSame('-1', $this->numeral(-1)->format()->value());
        $this->assertSame('-10', $this->numeral(-10)->format()->value());
        $this->assertSame('-25', $this->numeral(-25)->format()->value());

        $this->assertSame('0.2', $this->numeral(0.2)->format()->value());
        $this->assertSame('0.20', $this->numeral(0.2)->format(2)->value());
        $this->assertSame('0.123', $this->numeral(0.1234)->format(maxPrecision: 3)->value());
        $this->assertSame('1.23', $this->numeral(1.23)->format()->value());
        $this->assertSame('-1.23', $this->numeral(-1.23)->format()->value());
        $this->assertSame('123.456', $this->numeral(123.456)->format()->value());

        $this->assertSame('∞', $this->numeral(INF)->format()->value());
        $this->assertSame('NaN', $this->numeral(NAN)->format()->value());
    });

    it('formats numbers with different locales', function () {
        $this->assertSame('123,456,789', $this->numeral(123456789)->format(locale: 'en')->value());
        $this->assertSame('123.456.789', $this->numeral(123456789)->format(locale: 'de')->value());
        $this->assertSame('123 456 789', $this->numeral(123456789)->format(123456789, locale: 'fr')->value());
        $this->assertSame('123 456 789', $this->numeral(123456789)->format(locale: 'ru')->value());
        $this->assertSame('123 456 789', $this->numeral(123456789)->format(locale: 'sv')->value());
    });

    it('formats numbers with App locale', function () {
        $this->assertSame('123,456,789', $this->numeral(123456789)->format()->value());

        Number::useLocale('de');

        $this->assertSame('123.456.789', $this->numeral(123456789)->format()->value());

        Number::useLocale('en');
    });

    it('spells out numbers', function () {
        $this->assertSame('ten', $this->numeral(10)->spell()->value());
        $this->assertSame('one point two', $this->numeral(1.2)->spell()->value());
    });

    it('spell out numbers with locale', function () {
        $this->assertSame('trois', $this->numeral(3)->spell('fr')->value());
        $this->assertSame('drei', $this->numeral(3)->spell('de')->value());
        $this->assertSame('tres', $this->numeral(3)->spell('es')->value());
        $this->assertSame('три', $this->numeral(3)->spell('ru')->value());
        $this->assertSame('tre', $this->numeral(3)->spell('it')->value());
    });

    it('SpelloutWithThreshold', function () {
        $this->assertSame('9', $this->numeral(9)->spell(after: 10)->value());
        $this->assertSame('10', $this->numeral(10)->spell(after: 10)->value());
        $this->assertSame('eleven', $this->numeral(11)->spell(after: 10)->value());

        $this->assertSame('nine', $this->numeral(9)->spell(until: 10)->value());
        $this->assertSame('10', $this->numeral(10)->spell(until: 10)->value());
        $this->assertSame('11', $this->numeral(11)->spell(until: 10)->value());

        $this->assertSame('ten thousand', $this->numeral(10000)->spell(until: 50000)->value());
        $this->assertSame('100,000', $this->numeral(100000)->spell(until: 50000)->value());
    });

    it('Ordinal', function () {
        $this->assertSame('1st', $this->numeral(1)->ordinal()->value());
        $this->assertSame('2nd', $this->numeral(2)->ordinal()->value());
        $this->assertSame('3rd', $this->numeral(3)->ordinal()->value());
    });

    it('ToPercent', function () {
        $this->assertSame('0%', $this->numeral(0)->percentage(0)->value());
        $this->assertSame('0%', $this->numeral(0)->percentage()->value());
        $this->assertSame('1%', $this->numeral(1)->percentage()->value());
        $this->assertSame('10.00%', $this->numeral(10)->percentage(2)->value());
        $this->assertSame('100%', $this->numeral(100)->percentage()->value());
        $this->assertSame('100.00%', $this->numeral(100)->percentage(2)->value());
        $this->assertSame('100.123%', $this->numeral(100.1234)->percentage(maxPrecision: 3)->value());

        $this->assertSame('300%', $this->numeral(300)->percentage()->value());
        $this->assertSame('1,000%', $this->numeral(1000)->percentage()->value());

        $this->assertSame('2%', $this->numeral(1.75)->percentage()->value());
        $this->assertSame('1.75%', $this->numeral(1.75)->percentage(2)->value());
        $this->assertSame('1.750%', $this->numeral(1.75)->percentage(3)->value());
        $this->assertSame('0%', $this->numeral(0.12345)->percentage()->value());
        $this->assertSame('0.00%', $this->numeral(0)->percentage(2)->value());
        $this->assertSame('0.12%', $this->numeral(0.12345)->percentage(2)->value());
        $this->assertSame('0.1235%', $this->numeral(0.12345)->percentage(4)->value());
    });

    it('ToCurrency', function () {
        $this->assertSame('$0.00', $this->numeral(0)->currency()->value());
        $this->assertSame('$1.00', $this->numeral(1)->currency()->value());
        $this->assertSame('$10.00', $this->numeral(10)->currency()->value());

        $this->assertSame('€0.00', $this->numeral(0)->currency('EUR')->value());
        $this->assertSame('€1.00', $this->numeral(1)->currency('EUR')->value());
        $this->assertSame('€10.00', $this->numeral(10)->currency('EUR')->value());

        $this->assertSame('-$5.00', $this->numeral(-5)->currency()->value());
        $this->assertSame('$5.00', $this->numeral(5.00)->currency()->value());
        $this->assertSame('$5.32', $this->numeral(5.325)->currency()->value());
    });

    it('ToCurrencyWithDifferentLocale', function () {
        $this->assertSame('1,00 €', $this->numeral(1)->currency('EUR', 'de')->value());
        $this->assertSame('1,00 $', $this->numeral(1)->currency('USD', 'de')->value());
        $this->assertSame('1,00 £', $this->numeral(1)->currency('GBP', 'de')->value());

        $this->assertSame('123.456.789,12 $', $this->numeral(123456789.12345)->currency('USD', 'de')->value());
        $this->assertSame('123.456.789,12 €', $this->numeral(123456789.12345)->currency('EUR', 'de')->value());
        $this->assertSame('1 234,56 $US', $this->numeral(1234.56)->currency('USD', 'fr')->value());
    });

    it('BytesToHuman', function () {
        $this->assertSame('0 B', $this->numeral(0)->fileSize()->value());
        $this->assertSame('0.00 B', $this->numeral(0)->fileSize(2)->value());
        $this->assertSame('1 B', $this->numeral(1)->fileSize()->value());
        $this->assertSame('1 KB', $this->numeral(1024)->fileSize()->value());
        $this->assertSame('2 KB', $this->numeral(2048)->fileSize()->value());
        $this->assertSame('2.00 KB', $this->numeral(2048)->fileSize(2)->value());
        $this->assertSame('1.23 KB', $this->numeral(1264)->fileSize(2)->value());
        $this->assertSame('1.234 KB', $this->numeral(1264.12345)->fileSize(maxPrecision: 3)->value());
        $this->assertSame('1.234 KB', $this->numeral(1264)->fileSize(3)->value());
        $this->assertSame('5 GB', $this->numeral(1024 * 1024 * 1024 * 5)->fileSize()->value());
        $this->assertSame('10 TB', $this->numeral((1024 ** 4) * 10)->fileSize()->value());
        $this->assertSame('10 PB', $this->numeral((1024 ** 5) * 10)->fileSize()->value());
        $this->assertSame('1 ZB', $this->numeral(1024 ** 7)->fileSize()->value());
        $this->assertSame('1 YB', $this->numeral(1024 ** 8)->fileSize()->value());
        $this->assertSame('1,024 YB', $this->numeral(1024 ** 9)->fileSize()->value());
    });

    it('ToHuman', function () {
        $this->assertSame('1.0', $this->numeral(1)->forHumans(1)->value());
        $this->assertSame('1.00', $this->numeral(1)->forHumans(2)->value());
        $this->assertSame('10', $this->numeral(10)->forHumans()->value());
        $this->assertSame('100', $this->numeral(100)->forHumans()->value());
        $this->assertSame('1 thousand', $this->numeral(1000)->forHumans()->value());
        $this->assertSame('1.00 thousand', $this->numeral(1000)->forHumans(2)->value());
        $this->assertSame('1 thousand', $this->numeral(1000)->forHumans(maxPrecision: 2)->value());
        $this->assertSame('1 thousand', $this->numeral(1230)->forHumans()->value());
        $this->assertSame('1.2 thousand', $this->numeral(1230)->forHumans(maxPrecision: 1)->value());
        $this->assertSame('1 million', $this->numeral(1000000)->forHumans()->value());
        $this->assertSame('1 billion', $this->numeral(1000000000)->forHumans()->value());
        $this->assertSame('1 trillion', $this->numeral(1000000000000)->forHumans()->value());
        $this->assertSame('1 quadrillion', $this->numeral(1000000000000000)->forHumans()->value());
        $this->assertSame('1 thousand quadrillion', $this->numeral(1000000000000000000)->forHumans()->value());

        $this->assertSame('123', $this->numeral(123)->forHumans()->value());
        $this->assertSame('1 thousand', $this->numeral(1234)->forHumans()->value());
        $this->assertSame('1.23 thousand', $this->numeral(1234)->forHumans(2)->value());
        $this->assertSame('12 thousand', $this->numeral(12345)->forHumans()->value());
        $this->assertSame('1 million', $this->numeral(1234567)->forHumans()->value());
        $this->assertSame('1 billion', $this->numeral(1234567890)->forHumans()->value());
        $this->assertSame('1 trillion', $this->numeral(1234567890123)->forHumans()->value());
        $this->assertSame('1.23 trillion', $this->numeral(1234567890123)->forHumans(2)->value());
        $this->assertSame('1 quadrillion', $this->numeral(1234567890123456)->forHumans()->value());
        $this->assertSame('1.23 thousand quadrillion', $this->numeral(1234567890123456789)->forHumans(2)->value());
        $this->assertSame('490 thousand', $this->numeral(489939)->forHumans()->value());
        $this->assertSame('489.9390 thousand', $this->numeral(489939)->forHumans(4)->value());
        $this->assertSame('500.00000 million', $this->numeral(500000000)->forHumans(5)->value());

        $this->assertSame('1 million quadrillion', $this->numeral(1000000000000000000000)->forHumans()->value());
        $this->assertSame('1 billion quadrillion', $this->numeral(1000000000000000000000000)->forHumans()->value());
        $this->assertSame('1 trillion quadrillion', $this->numeral(1000000000000000000000000000)->forHumans()->value());
        $this->assertSame('1 quadrillion quadrillion', $this->numeral(1000000000000000000000000000000)->forHumans()->value());
        $this->assertSame('1 thousand quadrillion quadrillion', $this->numeral(1000000000000000000000000000000000)->forHumans()->value());

        $this->assertSame('0', $this->numeral(0)->forHumans()->value());
        $this->assertSame('0', $this->numeral(0.0)->forHumans()->value());
        $this->assertSame('0.00', $this->numeral(0)->forHumans(2)->value());
        $this->assertSame('0.00', $this->numeral(0.0)->forHumans(2)->value());
        $this->assertSame('-1', $this->numeral(-1)->forHumans()->value());
        $this->assertSame('-1.00', $this->numeral(-1)->forHumans(2)->value());
        $this->assertSame('-10', $this->numeral(-10)->forHumans()->value());
        $this->assertSame('-100', $this->numeral(-100)->forHumans()->value());
        $this->assertSame('-1 thousand', $this->numeral(-1000)->forHumans()->value());
        $this->assertSame('-1.23 thousand', $this->numeral(-1234)->forHumans(2)->value());
        $this->assertSame('-1.2 thousand', $this->numeral(-1234)->forHumans(maxPrecision: 1)->value());
        $this->assertSame('-1 million', $this->numeral(-1000000)->forHumans()->value());
        $this->assertSame('-1 billion', $this->numeral(-1000000000)->forHumans()->value());
        $this->assertSame('-1 trillion', $this->numeral(-1000000000000)->forHumans()->value());
        $this->assertSame('-1.1 trillion', $this->numeral(-1100000000000)->forHumans(maxPrecision: 1)->value());
        $this->assertSame('-1 quadrillion', $this->numeral(-1000000000000000)->forHumans()->value());
        $this->assertSame('-1 thousand quadrillion', $this->numeral(-1000000000000000000)->forHumans()->value());
    });

    it('Summarize', function () {
        $this->assertSame('1', $this->numeral(1)->abbreviate()->value());
        $this->assertSame('1.00', $this->numeral(1)->abbreviate(2)->value());
        $this->assertSame('10', $this->numeral(10)->abbreviate()->value());
        $this->assertSame('100', $this->numeral(100)->abbreviate()->value());
        $this->assertSame('1K', $this->numeral(1000)->abbreviate()->value());
        $this->assertSame('1.00K', $this->numeral(1000)->abbreviate(2)->value());
        $this->assertSame('1K', $this->numeral(1000)->abbreviate(maxPrecision: 2)->value());
        $this->assertSame('1K', $this->numeral(1230)->abbreviate()->value());
        $this->assertSame('1.2K', $this->numeral(1230)->abbreviate(maxPrecision: 1)->value());
        $this->assertSame('1M', $this->numeral(1000000)->abbreviate()->value());
        $this->assertSame('1B', $this->numeral(1000000000)->abbreviate()->value());
        $this->assertSame('1T', $this->numeral(1000000000000)->abbreviate()->value());
        $this->assertSame('1Q', $this->numeral(1000000000000000)->abbreviate()->value());
        $this->assertSame('1KQ', $this->numeral(1000000000000000000)->abbreviate()->value());

        $this->assertSame('123', $this->numeral(123)->abbreviate()->value());
        $this->assertSame('1K', $this->numeral(1234)->abbreviate()->value());
        $this->assertSame('1.23K', $this->numeral(1234)->abbreviate(2)->value());
        $this->assertSame('12K', $this->numeral(12345)->abbreviate()->value());
        $this->assertSame('1M', $this->numeral(1234567)->abbreviate()->value());
        $this->assertSame('1B', $this->numeral(1234567890)->abbreviate()->value());
        $this->assertSame('1T', $this->numeral(1234567890123)->abbreviate()->value());
        $this->assertSame('1.23T', $this->numeral(1234567890123)->abbreviate(2)->value());
        $this->assertSame('1Q', $this->numeral(1234567890123456)->abbreviate()->value());
        $this->assertSame('1.23KQ', $this->numeral(1234567890123456789)->abbreviate(2)->value());
        $this->assertSame('490K', $this->numeral(489939)->abbreviate()->value());
        $this->assertSame('489.9390K', $this->numeral(489939)->abbreviate(4)->value());
        $this->assertSame('500.00000M', $this->numeral(500000000)->abbreviate(5)->value());

        $this->assertSame('1MQ', $this->numeral(1000000000000000000000)->abbreviate()->value());
        $this->assertSame('1BQ', $this->numeral(1000000000000000000000000)->abbreviate()->value());
        $this->assertSame('1TQ', $this->numeral(1000000000000000000000000000)->abbreviate()->value());
        $this->assertSame('1QQ', $this->numeral(1000000000000000000000000000000)->abbreviate()->value());
        $this->assertSame('1KQQ', $this->numeral(1000000000000000000000000000000000)->abbreviate()->value());

        $this->assertSame('0', $this->numeral(0)->abbreviate()->value());
        $this->assertSame('0', $this->numeral(0.0)->abbreviate()->value());
        $this->assertSame('0.00', $this->numeral(0)->abbreviate(2)->value());
        $this->assertSame('0.00', $this->numeral(0.0)->abbreviate(2)->value());
        $this->assertSame('-1', $this->numeral(-1)->abbreviate()->value());
        $this->assertSame('-1.00', $this->numeral(-1)->abbreviate(2)->value());
        $this->assertSame('-10', $this->numeral(-10)->abbreviate()->value());
        $this->assertSame('-100', $this->numeral(-100)->abbreviate()->value());
        $this->assertSame('-1K', $this->numeral(-1000)->abbreviate()->value());
        $this->assertSame('-1.23K', $this->numeral(-1234)->abbreviate(2)->value());
        $this->assertSame('-1.2K', $this->numeral(-1234)->abbreviate(maxPrecision: 1)->value());
        $this->assertSame('-1M', $this->numeral(-1000000)->abbreviate()->value());
        $this->assertSame('-1B', $this->numeral(-1000000000)->abbreviate()->value());
        $this->assertSame('-1T', $this->numeral(-1000000000000)->abbreviate()->value());
        $this->assertSame('-1.1T', $this->numeral(-1100000000000)->abbreviate(maxPrecision: 1)->value());
        $this->assertSame('-1Q', $this->numeral(-1000000000000000)->abbreviate()->value());
        $this->assertSame('-1KQ', $this->numeral(-1000000000000000000)->abbreviate()->value());
    });

    it('Max', function () {
        $this->assertSame(3, $this->numeral(3)->max(2)->value());
        $this->assertSame(3, $this->numeral(3)->max(3)->value());
        $this->assertSame(4, $this->numeral(3)->max(4)->value());

        $this->assertSame(11.0, $this->numeral(11.0)->max(5.4)->value());
        $this->assertSame(11.0, $this->numeral(11.0)->max(11.0)->value());
        $this->assertSame(11.1, $this->numeral(11.0)->max(11.1)->value());
    });

    it('Min', function () {
        $this->assertSame(3, $this->numeral(3)->min(4)->value());
        $this->assertSame(3, $this->numeral(3)->min(3)->value());
        $this->assertSame(2, $this->numeral(3)->min(2)->value());

        $this->assertSame(11.0, $this->numeral(11.0)->min(11.1)->value());
        $this->assertSame(11.0, $this->numeral(11.0)->min(11.0)->value());
        $this->assertSame(5.4, $this->numeral(11.0)->min(5.4)->value());
    });

    it('Clamp', function () {
        $this->assertSame(2, $this->numeral(1)->clamp(2, 3)->value());
        $this->assertSame(3, $this->numeral(5)->clamp(2, 3)->value());
        $this->assertSame(5, $this->numeral(5)->clamp(1, 10)->value());
        $this->assertSame(4.5, $this->numeral(4.5)->clamp(1, 10)->value());
        $this->assertSame(1, $this->numeral(-10)->clamp(1, 5)->value());
    });

    it('Sum', function () {
        $this->assertSame(5, $this->numeral(2)->sum(3)->value());
        $this->assertSame(5.0, $this->numeral(2)->sum(3.0)->value());
        $this->assertSame(5.0, $this->numeral(2.0)->sum(3)->value());

        $this->assertSame(5, $this->numeral(-10)->sum(15)->value());
        $this->assertSame(5.0, $this->numeral(-10)->sum(15.0)->value());
        $this->assertSame(5.0, $this->numeral(-10.0)->sum(15)->value());

        $this->assertSame(5, $this->numeral(1)->sum(1, 1, 2)->value());
        $this->assertSame(5.0, $this->numeral(1)->sum(1.0, 1.0, 2.0)->value());
        $this->assertSame(5.0, $this->numeral(1.0)->sum(1, 1, 2)->value());

        $this->assertSame(5, $this->numeral(-10)->sum(15, -10, 10)->value());
    });

    it('Subtract', function () {
        $this->assertSame(-1, $this->numeral(2)->subtract(3)->value());
        $this->assertSame(-1.0, $this->numeral(2)->subtract(3.0)->value());
        $this->assertSame(-1.0, $this->numeral(2.0)->subtract(3)->value());

        $this->assertSame(-25, $this->numeral(-10)->subtract(15)->value());
        $this->assertSame(-25.0, $this->numeral(-10)->subtract(15.0)->value());
        $this->assertSame(-25.0, $this->numeral(-10.0)->subtract(15)->value());

        $this->assertSame(10, $this->numeral(25)->subtract(15)->value());
        $this->assertSame(10.0, $this->numeral(25)->subtract(15.0)->value());
        $this->assertSame(10.0, $this->numeral(25.0)->subtract(15)->value());
    });

    it('Multiply', function () {
        $this->assertSame(6, $this->numeral(2)->multiply(3)->value());
        $this->assertSame(6.0, $this->numeral(2)->multiply(3.0)->value());
        $this->assertSame(6.0, $this->numeral(2.0)->multiply(3)->value());

        $this->assertSame(-150, $this->numeral(-10)->multiply(15)->value());
        $this->assertSame(-150.0, $this->numeral(-10)->multiply(15.0)->value());
        $this->assertSame(-150.0, $this->numeral(-10.0)->multiply(15)->value());

        $this->assertSame(375, $this->numeral(25)->multiply(15)->value());
        $this->assertSame(375.0, $this->numeral(25)->multiply(15.0)->value());
        $this->assertSame(375.0, $this->numeral(25.0)->multiply(15)->value());

        $this->assertSame(-6, $this->numeral(6)->multiply(-1)->value());

        $this->assertSame(0, $this->numeral(0)->multiply(100)->value());
        $this->assertSame(0, $this->numeral(100)->multiply(0)->value());
    });

    it('Divide', function () {
        $this->assertSame(2, $this->numeral(6)->divide(3)->value());
        $this->assertSame(2.0, $this->numeral(6)->divide(3.0)->value());
        $this->assertSame(2.0, $this->numeral(6.0)->divide(3)->value());

        $this->assertSame(-10, $this->numeral(-150)->divide(15)->value());
        $this->assertSame(-10.0, $this->numeral(-150)->divide(15.0)->value());
        $this->assertSame(-10.0, $this->numeral(-150.0)->divide(15)->value());

        $this->assertSame(25, $this->numeral(375)->divide(15)->value());
        $this->assertSame(25.0, $this->numeral(375)->divide(15.0)->value());
        $this->assertSame(25.0, $this->numeral(375.0)->divide(15)->value());

        $this->assertSame(-6, $this->numeral(6)->divide(-1)->value());
    });

    it('Equals', function () {
        $this->assertTrue($this->numeral(3)->equals(3));

        $this->assertFalse($this->numeral(3.0)->equals(3));
        $this->assertFalse($this->numeral(3)->equals(3.0));
        $this->assertFalse($this->numeral(3)->equals(4));
        $this->assertFalse($this->numeral(3)->equals(3.1));
        $this->assertFalse($this->numeral(3.1)->equals(3));
    });

    it('NearlyEquals', function () {
        $this->assertTrue($this->numeral(3)->nearlyEquals(3));
        $this->assertTrue($this->numeral(3)->nearlyEquals(3.0));
        $this->assertTrue($this->numeral(3.0)->nearlyEquals(3));

        $this->assertTrue($this->numeral(3)->nearlyEquals(3.1, 0.1));
        $this->assertTrue($this->numeral(3.1)->nearlyEquals(3, 0.1));

        $this->assertFalse($this->numeral(3)->nearlyEquals(4));
        $this->assertFalse($this->numeral(3)->nearlyEquals(3.2));
        $this->assertFalse($this->numeral(3.2)->nearlyEquals(3));
    });

    it('GreaterThan', function () {
        $this->assertTrue($this->numeral(3)->greaterThan(2));
        $this->assertTrue($this->numeral(3)->greaterThan(2.9));
        $this->assertTrue($this->numeral(3.1)->greaterThan(3));
        $this->assertTrue($this->numeral(3)->greaterThan(-1));
        $this->assertTrue($this->numeral(3)->greaterThan(-1.0));
        $this->assertTrue($this->numeral(3.1)->greaterThan(-1));
        $this->assertTrue($this->numeral(3.1)->greaterThan(-1.0));
        $this->assertTrue($this->numeral(-3)->greaterThan(-5));
        $this->assertTrue($this->numeral(-3)->greaterThan(-5.0));
        $this->assertTrue($this->numeral(-3.1)->greaterThan(-5));
        $this->assertTrue($this->numeral(-3.1)->greaterThan(-5.0));

        $this->assertFalse($this->numeral(-3)->greaterThan(-3));
        $this->assertFalse($this->numeral(3)->greaterThan(3));
        $this->assertFalse($this->numeral(3)->greaterThan(3.1));
        $this->assertFalse($this->numeral(3.1)->greaterThan(3.1));
        $this->assertFalse($this->numeral(3)->greaterThan(4));
        $this->assertFalse($this->numeral(3)->greaterThan(4.0));
        $this->assertFalse($this->numeral(3.1)->greaterThan(4));
        $this->assertFalse($this->numeral(3.1)->greaterThan(4.0));
        $this->assertFalse($this->numeral(-3)->greaterThan(3));
        $this->assertFalse($this->numeral(-3)->greaterThan(3.0));
        $this->assertFalse($this->numeral(-3.1)->greaterThan(3));
        $this->assertFalse($this->numeral(-3.1)->greaterThan(3.0));
    });

    it('GraterThanOrEquals', function () {
        $this->assertTrue($this->numeral(3)->greaterThanOrEquals(2));
        $this->assertTrue($this->numeral(3)->greaterThanOrEquals(2.9));
        $this->assertTrue($this->numeral(3.1)->greaterThanOrEquals(3));
        $this->assertTrue($this->numeral(3)->greaterThanOrEquals(3));
        $this->assertTrue($this->numeral(3)->greaterThanOrEquals(-1));
        $this->assertTrue($this->numeral(3)->greaterThanOrEquals(-1.0));
        $this->assertTrue($this->numeral(3.1)->greaterThanOrEquals(-1));
        $this->assertTrue($this->numeral(3.1)->greaterThanOrEquals(-1.0));
        $this->assertTrue($this->numeral(-3)->greaterThanOrEquals(-3));
        $this->assertTrue($this->numeral(-3)->greaterThanOrEquals(-5));
        $this->assertTrue($this->numeral(-3)->greaterThanOrEquals(-5.0));
        $this->assertTrue($this->numeral(-3.1)->greaterThanOrEquals(-5));
        $this->assertTrue($this->numeral(-3.1)->greaterThanOrEquals(-5.0));

        $this->assertFalse($this->numeral(3)->greaterThanOrEquals(4));
        $this->assertFalse($this->numeral(3)->greaterThanOrEquals(4.0));
        $this->assertFalse($this->numeral(3.1)->greaterThanOrEquals(4));
        $this->assertFalse($this->numeral(3.1)->greaterThanOrEquals(4.0));
        $this->assertFalse($this->numeral(-3)->greaterThanOrEquals(3));
        $this->assertFalse($this->numeral(-3)->greaterThanOrEquals(3.0));
        $this->assertFalse($this->numeral(-3.1)->greaterThanOrEquals(3));
        $this->assertFalse($this->numeral(-3.1)->greaterThanOrEquals(3.0));
    });

    it('LessThan', function () {
        $this->assertTrue($this->numeral(2)->lessThan(3));
        $this->assertTrue($this->numeral(2.9)->lessThan(3));
        $this->assertTrue($this->numeral(3)->lessThan(3.1));
        $this->assertTrue($this->numeral(-1)->lessThan(3));
        $this->assertTrue($this->numeral(-1.0)->lessThan(3));
        $this->assertTrue($this->numeral(-1)->lessThan(3.1));
        $this->assertTrue($this->numeral(-1.0)->lessThan(3.1));
        $this->assertTrue($this->numeral(-3)->lessThan(-2));
        $this->assertTrue($this->numeral(-3)->lessThan(3));
        $this->assertTrue($this->numeral(-3)->lessThan(3.0));
        $this->assertTrue($this->numeral(-3.1)->lessThan(3));
        $this->assertTrue($this->numeral(-3.1)->lessThan(3.0));

        $this->assertFalse($this->numeral(3)->lessThan(3));
        $this->assertFalse($this->numeral(3.1)->lessThan(3));
        $this->assertFalse($this->numeral(3.1)->lessThan(3.1));
        $this->assertFalse($this->numeral(4)->lessThan(3));
        $this->assertFalse($this->numeral(4.0)->lessThan(3));
        $this->assertFalse($this->numeral(4)->lessThan(3.1));
        $this->assertFalse($this->numeral(4.0)->lessThan(3.1));
        $this->assertFalse($this->numeral(3)->lessThan(-3));
        $this->assertFalse($this->numeral(3.0)->lessThan(-3));
        $this->assertFalse($this->numeral(3)->lessThan(-3.1));
        $this->assertFalse($this->numeral(3.0)->lessThan(-3.1));
    });

    it('LessThanOrEquals', function () {
        $this->assertTrue($this->numeral(2)->lessThanOrEquals(3));
        $this->assertTrue($this->numeral(2.9)->lessThanOrEquals(3));
        $this->assertTrue($this->numeral(3)->lessThanOrEquals(3.1));
        $this->assertTrue($this->numeral(3)->lessThanOrEquals(3));
        $this->assertTrue($this->numeral(-1)->lessThanOrEquals(3));
        $this->assertTrue($this->numeral(-1.0)->lessThanOrEquals(3));
        $this->assertTrue($this->numeral(-1)->lessThanOrEquals(3.1));
        $this->assertTrue($this->numeral(-1.0)->lessThanOrEquals(3.1));
        $this->assertTrue($this->numeral(-3)->lessThanOrEquals(-2));
        $this->assertTrue($this->numeral(-3)->lessThanOrEquals(3));
        $this->assertTrue($this->numeral(-3)->lessThanOrEquals(3.0));
        $this->assertTrue($this->numeral(-3.1)->lessThanOrEquals(3));
        $this->assertTrue($this->numeral(-3.1)->lessThanOrEquals(3.0));
        $this->assertTrue($this->numeral(-3)->lessThanOrEquals(-3));

        $this->assertFalse($this->numeral(4)->lessThanOrEquals(3));
        $this->assertFalse($this->numeral(4.0)->lessThanOrEquals(3));
        $this->assertFalse($this->numeral(4)->lessThanOrEquals(3.1));
        $this->assertFalse($this->numeral(4.0)->lessThanOrEquals(3.1));
        $this->assertFalse($this->numeral(3)->lessThanOrEquals(-3));
        $this->assertFalse($this->numeral(3.0)->lessThanOrEquals(-3));
        $this->assertFalse($this->numeral(3)->lessThanOrEquals(-3.1));
        $this->assertFalse($this->numeral(3.0)->lessThanOrEquals(-3.1));
    });

    it('Between', function () {
        $this->assertTrue($this->numeral(3)->between(2, 4));
        $this->assertTrue($this->numeral(3)->between(3, 4));
        $this->assertTrue($this->numeral(3)->between(2, 3));
        $this->assertTrue($this->numeral(3)->between(3, 3));
        $this->assertTrue($this->numeral(-3)->between(-4, -2));
        $this->assertTrue($this->numeral(-3)->between(-3, -2));
        $this->assertTrue($this->numeral(-3)->between(-4, -3));
        $this->assertTrue($this->numeral(-3)->between(-3, -3));
        $this->assertTrue($this->numeral(3)->between(-4, 4));
        $this->assertTrue($this->numeral(3)->between(2, 4));
        $this->assertTrue($this->numeral(-3)->between(-4, 4));

        $this->assertFalse($this->numeral(-3)->between(4, -4));
        $this->assertFalse($this->numeral(3)->between(4, -4));
        $this->assertFalse($this->numeral(3)->between(4, 5));
        $this->assertFalse($this->numeral(3)->between(1, 2));
        $this->assertFalse($this->numeral(-3)->between(-2, -1));
        $this->assertFalse($this->numeral(-3)->between(-1, -2));
        $this->assertFalse($this->numeral(3)->between(4, 2));
        $this->assertFalse($this->numeral(-3)->between(4, 2));
        $this->assertFalse($this->numeral(-3)->between(2, 4));
    });

    it('Increment', function () {
        $this->assertSame(4, $this->numeral(3)->increment()->value());
        $this->assertSame(4.0, $this->numeral(3.0)->increment()->value());
        $this->assertSame(4, $this->numeral(3)->increment(1)->value());
        $this->assertSame(4.0, $this->numeral(3)->increment(1.0)->value());
        $this->assertSame(4.0, $this->numeral(3.0)->increment(1)->value());
        $this->assertSame(5, $this->numeral(3)->increment(2)->value());
        $this->assertSame(5.0, $this->numeral(3)->increment(2.0)->value());
        $this->assertSame(5.0, $this->numeral(3.0)->increment(2)->value());
    });

    it('Decrement', function () {
        $this->assertSame(2, $this->numeral(3)->decrement()->value());
        $this->assertSame(2.0, $this->numeral(3.0)->decrement()->value());
        $this->assertSame(2, $this->numeral(3)->decrement(1)->value());
        $this->assertSame(2.0, $this->numeral(3)->decrement(1.0)->value());
        $this->assertSame(2.0, $this->numeral(3.0)->decrement(1)->value());
        $this->assertSame(1, $this->numeral(3)->decrement(2)->value());
        $this->assertSame(1.0, $this->numeral(3)->decrement(2.0)->value());
        $this->assertSame(1.0, $this->numeral(3.0)->decrement(2)->value());
    });

    it('Abs', function () {
        $this->assertSame(3, $this->numeral(3)->abs()->value());
        $this->assertSame(3.0, $this->numeral(3.0)->abs()->value());
        $this->assertSame(3, $this->numeral(-3)->abs()->value());
        $this->assertSame(3.0, $this->numeral(-3.0)->abs()->value());
    });

    it('Ceil', function () {
        $this->assertSame(4.0, $this->numeral(3.1)->ceil()->value());
        $this->assertSame(4, $this->numeral(3.1)->ceil()->toInt()->value());
    });

    it('Floor', function () {
        $this->assertSame(3.0, $this->numeral(3.9)->floor()->value());
        $this->assertSame(3, $this->numeral(3.9)->floor()->toInt()->value());
    });

    it('rounds', function () {
        $this->assertSame(3, $this->numeral(3.1)->round()->toInt()->value());
        $this->assertSame(3.0, $this->numeral(3.1)->round()->value());
        $this->assertSame(4, $this->numeral(3.9)->round()->toInt()->value());
        $this->assertSame(4.0, $this->numeral(3.9)->round()->value());
        $this->assertSame(3.1, $this->numeral(3.14159)->round(1)->value());
        $this->assertSame(3.14, $this->numeral(3.14159)->round(2)->value());
        $this->assertSame(3.142, $this->numeral(3.14159)->round(3)->value());
        $this->assertSame(3.1416, $this->numeral(3.14159)->round(4)->value());
        $this->assertSame(3.14159, $this->numeral(3.14159)->round(5)->value());
    });

    it('Len', function () {
        $this->assertSame(1, $this->numeral(3)->len());
        $this->assertSame(1, $this->numeral(3.0)->len());
        $this->assertSame(2, $this->numeral(30)->len());
        $this->assertSame(2, $this->numeral(30.0)->len());
        $this->assertSame(3, $this->numeral(300)->len());
        $this->assertSame(3, $this->numeral(300.0)->len());
    });

    it('Sqrt', function () {
        $this->assertSame(3, $this->numeral(9)->sqrt()->toInt()->value());
        $this->assertSame(3.0, $this->numeral(9)->sqrt()->value());
        $this->assertSame(3.0, $this->numeral(9.0)->sqrt()->value());
    });

    it('Cbrt', function () {
        $this->assertSame(3.0, $this->numeral(27)->cbrt()->value());
        $this->assertSame(3.0, $this->numeral(27.0)->cbrt()->value());
    });

    it('Pow', function () {
        $this->assertSame(9, $this->numeral(3)->pow(2)->value());
        $this->assertSame(9.0, $this->numeral(3.0)->pow(2)->value());
    });

    it('Mod', function () {
        $this->assertSame(1, $this->numeral(10)->mod(3)->value());
        $this->assertSame(1, $this->numeral(10.0)->mod(3)->value());
    });

    it('Log', function () {
        $this->assertSame(4.605170185988092, $this->numeral(100)->log()->value());
        $this->assertSame(4.605170185988092, $this->numeral(100.0)->log()->value());
    });

    it('Log10', function () {
        $this->assertSame(2.0, $this->numeral(100)->log10()->value());
        $this->assertSame(2.0, $this->numeral(100.0)->log10()->value());
    });

    it('Log1p', function () {
        $this->assertSame(4.61512051684126, $this->numeral(100)->log1p()->value());
        $this->assertSame(4.61512051684126, $this->numeral(100.0)->log1p()->value());
    });

    it('Exp', function () {
        $this->assertSame(20.085536923187668, $this->numeral(3)->exp()->value());
        $this->assertSame(20.085536923187668, $this->numeral(3.0)->exp()->value());
    });

    it('Expm1', function () {
        $this->assertSame(19.085536923187668, $this->numeral(3)->expm1()->value());
        $this->assertSame(19.085536923187668, $this->numeral(3.0)->expm1()->value());
    });

    it('Cos', function () {
        $this->assertSame(-0.9899924966004454, $this->numeral(3)->cos()->value());
        $this->assertSame(-0.9899924966004454, $this->numeral(3.0)->cos()->value());
    });

    it('Sin', function () {
        $this->assertSame(0.1411200080598672, $this->numeral(3)->sin()->value());
        $this->assertSame(0.1411200080598672, $this->numeral(3.0)->sin()->value());
    });

    it('Tan', function () {
        $this->assertSame(-0.1425465430742778, $this->numeral(3)->tan()->value());
        $this->assertSame(-0.1425465430742778, $this->numeral(3.0)->tan()->value());
    });

    it('Acos', function () {
        $this->assertSame(1.4706289056333368, $this->numeral(0.1)->acos()->value());
        $this->assertSame(1.4706289056333368, $this->numeral(0.1)->acos()->value());
    });

    it('Asin', function () {
        $this->assertSame(0.1001674211615598, $this->numeral(0.1)->asin()->value());
        $this->assertSame(0.1001674211615598, $this->numeral(0.1)->asin()->value());
    });

    it('Atan', function () {
        $this->assertSame(0.09966865249116204, $this->numeral(0.1)->atan()->value());
        $this->assertSame(0.09966865249116204, $this->numeral(0.1)->atan()->value());
    });

    it('Atan2', function () {
        $this->assertSame(0.7853981633974483, $this->numeral(1)->atan2(1)->value());
        $this->assertSame(0.7853981633974483, $this->numeral(1.0)->atan2(1)->value());
        $this->assertSame(0.7853981633974483, $this->numeral(1)->atan2(1.0)->value());
        $this->assertSame(0.7853981633974483, $this->numeral(1.0)->atan2(1.0)->value());
    });

    it('Cosh', function () {
        $this->assertSame(10.067661995777765, $this->numeral(3)->cosh()->value());
        $this->assertSame(10.067661995777765, $this->numeral(3.0)->cosh()->value());
    });

    it('Sinh', function () {
        $this->assertSame(10.017874927409903, $this->numeral(3)->sinh()->value());
        $this->assertSame(10.017874927409903, $this->numeral(3.0)->sinh()->value());
    });

    it('Tanh', function () {
        $this->assertSame(0.9950547536867305, $this->numeral(3)->tanh()->value());
        $this->assertSame(0.9950547536867305, $this->numeral(3.0)->tanh()->value());
    });

    it('Acosh', function () {
        $this->assertSame(1.762747174039086, $this->numeral(3)->acosh()->value());
        $this->assertSame(1.762747174039086, $this->numeral(3.0)->acosh()->value());
    });

    it('Asinh', function () {
        $this->assertSame(1.8184464592320668, $this->numeral(3)->asinh()->value());
        $this->assertSame(1.8184464592320668, $this->numeral(3.0)->asinh()->value());
    });

    it('Atanh', function () {
        $this->assertSame(1.0986122886681098, $this->numeral(0.8)->atanh()->value());
        $this->assertSame(1.0986122886681098, $this->numeral(0.8)->atanh()->value());
    });

    it('GreatestCommonDivisor', function () {
        $this->assertSame(1, $this->numeral(3)->gcd(2)->value());
        $this->assertSame(1, $this->numeral(3.0)->gcd(2)->value());
        $this->assertSame(1, $this->numeral(3)->gcd(2.0)->value());
        $this->assertSame(1, $this->numeral(3.0)->gcd(2.0)->value());
        $this->assertSame(1, $this->numeral(1)->gcd(1)->value());
        $this->assertSame(1, $this->numeral(1)->gcd(2)->value());
        $this->assertSame(1, $this->numeral(2)->gcd(1)->value());
        $this->assertSame(2, $this->numeral(2)->gcd(2)->value());
        $this->assertSame(2, $this->numeral(2)->gcd(4)->value());
        $this->assertSame(2, $this->numeral(4)->gcd(2)->value());
        $this->assertSame(2, $this->numeral(4)->gcd(6)->value());
        $this->assertSame(2, $this->numeral(6)->gcd(4)->value());
        $this->assertSame(3, $this->numeral(3)->gcd(3)->value());
        $this->assertSame(3, $this->numeral(3)->gcd(6)->value());
        $this->assertSame(3, $this->numeral(6)->gcd(3)->value());
        $this->assertSame(3, $this->numeral(6)->gcd(9)->value());
        $this->assertSame(3, $this->numeral(9)->gcd(6)->value());
        $this->assertSame(3, $this->numeral(9)->gcd(12)->value());
        $this->assertSame(3, $this->numeral(12)->gcd(9)->value());
        $this->assertSame(3, $this->numeral(12)->gcd(15)->value());
        $this->assertSame(3, $this->numeral(15)->gcd(12)->value());
        $this->assertSame(3, $this->numeral(15)->gcd(18)->value());
        $this->assertSame(3, $this->numeral(18)->gcd(15)->value());
    });

    it('LowestCommonMultiplier', function () {
        $this->assertSame(6, $this->numeral(3)->lcm(2)->value());
        $this->assertSame(6.0, $this->numeral(3.0)->lcm(2)->value());
        $this->assertSame(6.0, $this->numeral(3)->lcm(2.0)->value());
        $this->assertSame(6.0, $this->numeral(3.0)->lcm(2.0)->value());
        $this->assertSame(1, $this->numeral(1)->lcm(1)->value());
        $this->assertSame(2, $this->numeral(1)->lcm(2)->value());
        $this->assertSame(2, $this->numeral(2)->lcm(1)->value());
        $this->assertSame(2, $this->numeral(2)->lcm(2)->value());
        $this->assertSame(4, $this->numeral(2)->lcm(4)->value());
        $this->assertSame(4, $this->numeral(4)->lcm(2)->value());
        $this->assertSame(6, $this->numeral(2)->lcm(3)->value());
        $this->assertSame(6, $this->numeral(3)->lcm(2)->value());
        $this->assertSame(3, $this->numeral(3)->lcm(3)->value());
        $this->assertSame(6, $this->numeral(3)->lcm(6)->value());
        $this->assertSame(6, $this->numeral(6)->lcm(3)->value());
        $this->assertSame(6, $this->numeral(6)->lcm(6)->value());
        $this->assertSame(12, $this->numeral(3)->lcm(4)->value());
        $this->assertSame(12, $this->numeral(4)->lcm(3)->value());
        $this->assertSame(4, $this->numeral(4)->lcm(4)->value());
        $this->assertSame(12, $this->numeral(4)->lcm(6)->value());
        $this->assertSame(12, $this->numeral(6)->lcm(4)->value());
        $this->assertSame(6, $this->numeral(6)->lcm(6)->value());
        $this->assertSame(15, $this->numeral(3)->lcm(5)->value());
        $this->assertSame(15, $this->numeral(5)->lcm(3)->value());
        $this->assertSame(5, $this->numeral(5)->lcm(5)->value());
    });

    it('Factorial', function () {
        $this->assertSame(1, $this->numeral(0)->factorial()->value());
        $this->assertSame(1, $this->numeral(1)->factorial()->value());
        $this->assertSame(2, $this->numeral(2)->factorial()->value());
        $this->assertSame(6, $this->numeral(3)->factorial()->value());
        $this->assertSame(24, $this->numeral(4)->factorial()->value());
        $this->assertSame(120, $this->numeral(5)->factorial()->value());
        $this->assertSame(720, $this->numeral(6)->factorial()->value());
        $this->assertSame(5040, $this->numeral(7)->factorial()->value());
        $this->assertSame(40320, $this->numeral(8)->factorial()->value());
        $this->assertSame(362880, $this->numeral(9)->factorial()->value());
        $this->assertSame(3628800, $this->numeral(10)->factorial()->value());
    });

    it('copies signs', function () {
        $this->assertSame(3, $this->numeral(3)->copySign(2)->value());
        $this->assertSame(3.0, $this->numeral(3.0)->copySign(2)->value());
        $this->assertSame(-3, $this->numeral(3)->copySign(-2)->value());
        $this->assertSame(-3.0, $this->numeral(3.0)->copySign(-2)->value());
        $this->assertSame(3, $this->numeral(-3)->copySign(2)->value());
        $this->assertSame(3.0, $this->numeral(-3.0)->copySign(2)->value());
        $this->assertSame(-3, $this->numeral(-3)->copySign(-2)->value());
        $this->assertSame(-3.0, $this->numeral(-3.0)->copySign(-2)->value());
        $this->assertSame(3, $this->numeral(3)->copySign(0)->value());
    });

    it('returns the value', function () {
        $this->assertSame(3, $this->numeral(3)->value());
        $this->assertSame(11.0, $this->numeral(11.0)->value());
    });

    it('casts to string', function () {
        $this->assertSame('3', $this->numeral(3)->toString());
        $this->assertSame('11', $this->numeral(11.0)->toString());
    });

    it('casts to int', function () {
        $this->assertSame(3, $this->numeral(3)->toInt()->value());
        $this->assertSame(11, $this->numeral(11.0)->toInt()->value());
        $this->assertSame(-3, $this->numeral(-3)->toInt()->value());
        $this->assertSame(-11, $this->numeral(-11.0)->toInt()->value());
    });

    it('converts scientific to real', function () {
        $this->assertSame(1000000, $this->numeral(1e6)->toInt()->value());
        $this->assertSame(1000000, $this->numeral(1e6)->value());
        $this->assertSame(0.000001, $this->numeral(1e-6)->value());
        $this->assertSame(0.000001, $this->numeral(1e-6)->value());
    });
});
