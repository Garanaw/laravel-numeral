# laravel-numeral

---

## What is it?

This package inlines the Number helper with the Str helper. It does so by adding some functionality as well as introducing a number of tools:

## Garanaw\LaravelNumeral\Support\Numeral

This class is the one that should align with the existing Stringable. This wrapper allows chaining operations on numbers. Most of the native operations from PHP have been added, along with other helper functions. Some basic equations like fractals have been also added to this.

It uses the same traits than its sibling Stringable, however it's lacking some interfaces (JsonSerializable, ArrayAccess) as those don't apply to this scalar. PHP's \Stringable (not to be confused with Illuminate\Support\Stringable) is implemented in order to cast the value to a string and allow visual representation in Blade (this is done with the existing Number's method format().

The decision of using this name instead of Numerable to fully align it with Stringable is due to the definition provided by Oxford's dictionary for the word "numeral": able to be counted

The class supports integers and floats.

## Garanaw\LaravelNumeral\Support\Number

New functionality has been added to this helper. Not everything that appears in Numeral has been doubled here, because simple operations such as additions would imply more cumbersomeness when used here rather than just doing 1 + 1.

However, a new random() method has been introduced here as a wrapper for PHP's Random\Randomizer(). This functionality doesn't exist in the stateful class

## num()

To mimic the str() helper, a new num() helper has been introduced with similar functionality. This helper will return a Numeral object with the value passed as a parameter.

## Garanaw\LaravelNumeral\Casts\AsNumeral

A new cast has also been added to the Eloquent's Casts folder. This will cast integers and floats to Numerals and back.