Pentothal (WIP)
===============

Higher order predicates library.

## What?

An higher order function is a function that returns a function, or that takes a function as argument.

A functional predicate is a function that receives one or more arguments and return true or false.

This library is a collections of functions that returns functional predicates.

## Why?

In PHP there are some function like `array_map`, `array_filter` and so on that takes a functional predicate
as argument.

For example:

```php
$data = [
  'foo',
  1,
  true,
  'bar',
  [],
  ''
];

$strings = array_filter($data, 'is_string'); // ['foo', 'bar', '']
```

This can be done thanks to the fact that a `is_string` is a named function. But if we need to also strip
empty strings, we need to:

```php
$strings = array_filter($data, function($item) {
    return is_string($item) && $item !== '';
});
```

One of the functions of this library is `isType()` that accepts a type and returns a predicate.

Another function is `combine()` that takes an arbitrary number of predicates and returns a predicate
that return true when all the combined predicates return true.

Using these 2 functions the code above can be written like this:

```php
use Pentothal as P;

$strings = array_filter($data, P\combine(P\isType('string'), P\isNotEmpty()));
```

All the functions in the library are in the Pentothal namespace.


## List of functions

Here a list of all the functions currently provided by library (namespace omitted):

### General

 - `always()` Return a predicate that always return `true`
 - `never()` Return a predicate that always return `false`
 - `isEmpty()`
 - `isNotEmpty()`
 
### Comparison
 
 - `isSame($value)`
 - `isNotSame($value)`
 - `isEqual($value)`
 - `isNotEqual($value)`
 - `match($regex)` 
 - `notMatch()`
 
### Type check

 - `isType($type)` Works with scalar types, classes and interfaces
 - `isNotType($type)`
 - `isInt()`
 - `isNotInt()`
 - `isFloat()`
 - `isNotFloat()`
 - `isNumber()`
 - `isNotNumber()`
 - `isString()`
 - `isNotString()`
 - `isBool()`
 - `isNotBool()`
 - `isNull()`
 - `isNotNull()`
 - `isObject()`
 - `isNotObject()`
 - `isArray()`
 - `isNotArray()`
 - `isEmail()`
 - `isNotEmail()`
 - `isUrl()`
 - `isNotUrl()`
 - `isIp()`
 - `isNotIp()`
 - `isMac()`
 - `isNotMac()`
 
### Size check

 - `size($size)` Verify elements count of arrays and countable objects and string length
 - `sizeMax($size)`
 - `sizeMaxStrict($size)`
 - `sizeMin($size)`
 - `sizeMinStrict($size)`
 - `between($min, $max)`
 - `notBetween($min, $max)`
 - `betweenInner($min, $max)`
 - `notBetweenInner($min, $max)`
 - `betweenLeft($min, $max)`
 - `notBetweenLeft($min, $max)`
 - `betweenRight($min, $max)`
 - `notBetweenRight($min, $max)`
 
### Elements check (for arrays and strings)

 - `contain($item)` Verify `$item` is present in arrays, or if both `$item` and subject are strings check the subject contain `$item`
 - `notContain($item)`
 - `startWith($item)` Verify first element of arrays, or if both `$item` and subject are strings check the subject string starts with `$item`
 - `notStartWith($item)` Verify first element of arrays, or if both `$item` and subject are strings check the subject string starts with `$item`
 - `endWith($item)`
 - `notEndWith($item)`
 
### Elements check for arrays only

 - `anyOfValues(array $values)` Verify array subject for intersection with given values
 - `notAnyOfValues(array $values)`
 - `anyOf(...$values)` Like `anyOfValues` but with variadic arguments
 - `notAnyOf(...$values)`
 
### Elements check for arrays and objects
 
 - `hasValue($value)` Return a predicate that checks an array or a traversable object to find an element equal to value given
 - `hasNotValue($value)`
 - `hasValues(array $value)`
 - `hasNotValues(array $value)`
 - `hasAnyOfValues(array $value)`
 - `hasNotAnyOfValues(array $value)`
 
### Object properties check (works with associative arrays as well)

 - `hasKey($key)`
 - `hasNotKey($key)`
 - `hasKeys(...$keys)`
 - `hasNotKeys(...$keys)`
 - `hasAnyOfKeys(...$keys)`
 - `hasNotAnyOfKeys(...$keys)`
 - `keyIs($key, $value)`
 - `keyIsNot($key, $value)`
 - `keyIsAnyOf($key, array values)`
 - `keyIsNotAnyOf($key, array $values)`
 - `keyIsType($key, $type)`
 - `keyInNotType($key, $type)`
 - `keyApply($key, callable $predicate)` Return a predicate that applies a predicate to a key of the subject
 - `notKeyApply($key, callable $predicate)`
 
### Object methods check

 - `hasMethod($method)`
 - `hasNotMethod($method)`
 - `methodReturn($method, $value)`
 - `methodNotReturn($method, $value)`
 - `methodReturnAnyOf($method, array $values)`
 - `methodNotReturnAnyOf($method, array $values)`
 - `methodReturnType($method, $type)`
 - `methodNotReturnType($method, $type)`
 - `methodReturnEmpty($method)`
 - `methodReturnNotEmpty($method)`
 - `methodReturnApply($method, callable $predicate)` Return a predicate that applies a predicate return value of given method of the subject

 
### Bulk

 - `bulk(callable $predicate)` Return a predicate that applies the same predicate to an array of values and returns true when the given predicate return true for all values
 - `bulkPool(callable $predicate)` Like `bulk()` but returned predicate return `true` the given predicate returns `true` for any of the values

### Predicates composition

- `negate(callable $predicate)` Return a predicate that return `true` when given predicate return `false` and viceversa
- `combine(...$predicates)` Return a predicate that returns `true` when all the given predicates returns true
- `pool(...$predicates)` Return a predicate that returns `true` when any of the given predicates returns true
- `combineCallbacks(array $predicates)` Like `combine()` but accepts an array of predicates
- `poolCallbacks(...$predicates)` Like `pool()` but accepts an array of predicates
- `combineMap($predicates)` Takes a map of predicates and return a predicates that applies to a map value, returns true when all the predicates return true
- `poolMap($predicates)` Like combineMap, but the returned predicates return `true` when any the predicates returns `true`
 
## Quite Complex Example

```php
// some example data
$countableOne = new \ArrayObject(['foo' => 'bar']);
$countableTwo = new \ArrayObject(['a' => 'a', 'b' => 'b']);
$plainObj = new \stdClass();
$string1 = 'a';
$string3 = 'abc';
$number1 = 1;
$number3 = 3;

$list = [
  'a' => $countableOne,
  'b' => $countableTwo,
  'c' => $plainObj,
  'd' => $string1,
  'e' => $string3,
  'f' => $number1,
  'g' => $number3
];


$predicate = P\combine(
  P\pool(P\isNotObject(), P\isType('Countable')), // filter out: ['c' => $plainObj]
  P\pool(P\isNotString(), P\size(3)), // filter out: ['d' => $string1]
  P\pool(P\isString(), P\size(1)) // filter out: ['a' => $countableTwo, 'g' => $number3]
);

$negatePredicate = negate($predicate);

$in = array_filter($list, $predicate);
$out = array_filter($list, $negatePredicate);

var_dump($in); // array('a' => $countableOne, 'e' => $string3, 'f' => $number1];
var_dump($out); // array('b' => $countableTwo, 'c' => $plainObj, 'd' => $string1, 'g' => $number3];    
```