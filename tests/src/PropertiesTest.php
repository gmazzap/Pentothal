<?php
/*
 * This file is part of the Pentothal package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pentothal\Tests;

use PHPUnit_Framework_TestCase;
use Pentothal as P;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package Pentothal
 */
final class PropertiesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider hasKeyDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param bool   $expected
     */
    public function testHasKey($subject, $key, $expected)
    {
        $hasKey = P\hasKey($key);

        $expected ? assertTrue($hasKey($subject)) : assertFalse($hasKey($subject));
    }

    /**
     * @dataProvider hasKeyDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param bool   $notExpected
     */
    public function testHasNotKey($subject, $key, $notExpected)
    {
        $hasNotKey = P\hasNotKey($key);

        $notExpected ? assertFalse($hasNotKey($subject)) : assertTrue($hasNotKey($subject));
    }

    public function hasKeyDataProvider()
    {
        return [
            [['foo' => 'bar'], 'foo', true],
            [['foo' => 'bar'], '', false],
            [['foo', 'bar'], 'foo', false],
            [new \ArrayObject(['foo' => 'bar']), 'foo', true],
            [new \ArrayObject(['foo' => 'bar']), 'bar', false],
            [(object) ['foo' => 'bar'], 'foo', true],
            [true, '', false],
        ];
    }

    /**
     * @dataProvider hasKeysDataProvider
     * @param mixed $subject
     * @param array $keys
     * @param bool  $expected
     */
    public function testHasKeys($subject, array $keys, $expected)
    {
        $hasKeys = P\hasKeys($keys);

        $expected ? assertTrue($hasKeys($subject)) : assertFalse($hasKeys($subject));
    }

    /**
     * @dataProvider hasKeysDataProvider
     * @param mixed $subject
     * @param array $keys
     * @param bool  $notExpected
     */
    public function testHasNotKeys($subject, array $keys, $notExpected)
    {
        $hasNotKeys = P\hasNotKeys($keys);

        $notExpected ? assertFalse($hasNotKeys($subject)) : assertTrue($hasNotKeys($subject));
    }

    public function hasKeysDataProvider()
    {
        return [
            [['foo' => 'bar'], ['foo'], true],
            [['foo' => 'bar', 'bar' => 'baz'], ['foo'], true],
            [['foo' => 'bar', 'bar' => 'baz'], ['foo', 'bar'], true],
            [['foo' => 'bar', 'bar' => 'baz'], ['foo', 'bar', 'baz'], false],
            [(object) ['foo' => 'bar'], ['foo'], true],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], ['foo'], true],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], ['foo', 'bar'], true],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], ['foo', 'bar', 'baz'], false],
            [['foo', 'bar'], ['foo', 'bar'], false],
            [['foo', 'bar'], ['foo'], false],
            [true, [], false],
        ];
    }

    /**
     * @dataProvider hasAnyOfKeysDataProvider
     * @param mixed $subject
     * @param array $keys
     * @param bool  $expected
     */
    public function testHasAnyOfKeys($subject, array $keys, $expected)
    {
        $hasAnyOfKeys = P\hasAnyOfKeys($keys);

        $expected ? assertTrue($hasAnyOfKeys($subject)) : assertFalse($hasAnyOfKeys($subject));
    }

    /**
     * @dataProvider hasAnyOfKeysDataProvider
     * @param mixed $subject
     * @param array $keys
     * @param bool  $notExpected
     */
    public function testHasNotAnyOfKeys($subject, array $keys, $notExpected)
    {
        $hasNotAnyOfKeys = P\hasNotAnyOfKeys($keys);

        $notExpected ? assertFalse($hasNotAnyOfKeys($subject)) : assertTrue($hasNotAnyOfKeys($subject));
    }

    public function hasAnyOfKeysDataProvider()
    {
        return [
            [['foo' => 'bar', 'bar' => 'baz'], ['foo'], true],
            [['foo' => 'bar', 'bar' => 'baz'], ['bar'], true],
            [['foo' => 'bar', 'bar' => 'baz'], ['foo', 'bar'], true],
            [['foo' => 'bar', 'bar' => 'baz'], ['baz'], false],
            [['foo' => 'bar', 'bar' => 'baz'], ['baz', 'x', 'y'], false],
            [['foo' => 'bar', 'bar' => 'baz'], ['foo', 'baz'], true],
            ['', [''], false],
            [[''], [''], false],
        ];
    }

    /**
     * @dataProvider keyIsDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param mixed  $value
     * @param bool   $expected
     */
    public function testKeyIs($subject, $key, $value, $expected)
    {
        $keyIs = P\keyIs($key, $value);

        $expected ? assertTrue($keyIs($subject)) : assertFalse($keyIs($subject));
    }

    /**
     * @dataProvider keyIsDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param mixed  $value
     * @param bool   $notExpected
     */
    public function testKeyIsNot($subject, $key, $value, $notExpected)
    {
        $keyIsNot = P\keyIsNot($key, $value);

        $notExpected ? assertFalse($keyIsNot($subject)) : assertTrue($keyIsNot($subject));
    }

    public function keyIsDataProvider()
    {
        return [
            [['foo' => 'bar', 'bar' => 'baz'], 'foo', 'bar', true],
            [['foo' => 'bar', 'bar' => 'baz'], 'bar', 'baz', true],
            [['foo' => 'bar', 'bar' => 'baz'], 'meh', 'baz', false],
            [['foo' => 'bar', 'bar' => 'baz'], 'foo', 'meh', false],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], 'foo', 'bar', true],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], 'bar', 'baz', true],
            [new \ArrayObject(['foo' => 'bar', 'bar' => 'baz']), 'meh', 'baz', false],
            [new \ArrayObject(['foo' => 'bar', 'bar' => 'baz']), 'foo', 'meh', false],
            ['foo', 'foo', 'meh', false],
            [['foo' => 'bar', 'bar' => 'baz'], ['foo'], 'bar', false],
        ];
    }

    /**
     * @dataProvider keyIsAnyOfDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param array  $values
     * @param bool   $expected
     */
    public function testKeyIsAnyOf($subject, $key, array $values, $expected)
    {
        $keyIs = P\keyIsAnyOf($key, $values);

        $expected ? assertTrue($keyIs($subject)) : assertFalse($keyIs($subject));
    }

    /**
     * @dataProvider keyIsAnyOfDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param array  $values
     * @param bool   $notExpected
     */
    public function testKeyIsNotAnyOf($subject, $key, array $values, $notExpected)
    {
        $keyIsNot = P\keyIsNotAnyOf($key, $values);

        $notExpected ? assertFalse($keyIsNot($subject)) : assertTrue($keyIsNot($subject));
    }

    public function keyIsAnyOfDataProvider()
    {
        return [
            [['foo' => 'bar', 'bar' => 'baz'], 'foo', ['bar'], true],
            [['foo' => 'bar', 'bar' => 'baz'], 'foo', ['x', 'y', 'bar'], true],
            [['foo' => 'bar', 'bar' => 'baz'], 'foo', ['x', 'y', 'baz'], false],
            [['foo' => 'bar', 'bar' => 'baz'], 'foo', [], false],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], 'foo', ['bar'], true],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], 'foo', ['x', 'y', 'bar'], true],
            [new \ArrayObject(['foo' => 'bar', 'bar' => 'baz']), 'foo', ['x', 'y', 'baz'], false],
            [new \ArrayObject(['foo' => 'bar', 'bar' => 'baz']), 'foo', [], false],
        ];
    }

    /**
     * @dataProvider keyIsTypeDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param string $type
     * @param bool   $expected
     */
    public function testKeyIsType($subject, $key, $type, $expected)
    {
        $keyIs = P\keyIsType($key, $type);

        $expected ? assertTrue($keyIs($subject)) : assertFalse($keyIs($subject));
    }

    /**
     * @dataProvider keyIsTypeDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param string $type
     * @param bool   $notExpected
     */
    public function testKeyIsNotType($subject, $key, $type, $notExpected)
    {
        $keyIsNot = P\keyIsNotType($key, $type);

        $notExpected ? assertFalse($keyIsNot($subject)) : assertTrue($keyIsNot($subject));
    }

    public function keyIsTypeDataProvider()
    {
        return [
            [['foo' => 'bar', 'bar' => ['baz']], 'foo', 'string', true],
            [['foo' => 'bar', 'bar' => ['baz']], 'bar', 'array', true],
            [['foo' => 1, 'bar' => true], 'foo', 'int', true],
            [['foo' => 1, 'bar' => true], 'bar', 'bool', true],
            [['foo' => 1.0, 'bar' => new \stdClass()], 'foo', 'float', true],
            [['foo' => 1.0, 'bar' => new \stdClass()], 'bar', 'object', true],
            [['foo' => null, 'bar' => new \stdClass()], 'foo', 'null', true],
            [['foo' => null, 'bar' => new \stdClass()], 'foo', null, false],
            [['foo' => 1.0, 'bar' => new \stdClass()], 'bar', 'stdClass', true],
            [['foo' => '', 'bar' => new Stubs\CountThree()], 'bar', Stubs\CountThree::class, true],
            [['foo' => '', 'bar' => new Stubs\CountThree()], 'bar', 'Countable', true],
            [['foo' => '', 'bar' => new Stubs\CountThree()], 'bar', 'object', true],
            [['foo' => 'bar', 'bar' => ['baz']], 'foo', 'array', false],
            [['foo' => 'bar', 'bar' => ['baz']], 'bar', 'string', false],
            [[], '', 'string', false],
            [[], '', 'null', false],
        ];
    }

    /**
     * @dataProvider keyApplyDataProvider
     * @param mixed  $subject
     * @param string $key
     * @param bool   $expected
     */
    public function testKeyApplyTest($subject, $key, $expected)
    {
        $callback = function ($value) {
            return is_string($value) && substr_count($value, 'x');
        };

        $keyApply = P\keyApply($key, $callback);

        $expected ? assertTrue($keyApply($subject)) : assertFalse($keyApply($subject));
    }

    public function keyApplyDataProvider()
    {
        return [
            ['x', 'x', false],
            [['x'], 'x', false],
            [['x' => 'x'], 'x', true],
            [['x' => 'x'], ['x'], false],
            [['y' => 'x'], ['x'], false],
            [(object) ['x' => 'x'], 'x', true],
            [new \ArrayObject(['x' => 'x']), 'x', true],
        ];
    }

    /**
     * @dataProvider hasValueDataProvider
     * @param array|object $subject
     * @param mixed        $value
     * @param              $expected
     */
    public function testHasValue($subject, $value, $expected)
    {
        $hasValue = P\hasValue($value);

        $expected ? assertTrue($hasValue($subject)) : assertFalse($hasValue($subject));
    }

    /**
     * @dataProvider hasValueDataProvider
     * @param array|object $subject
     * @param mixed        $value
     * @param              $notExpected
     */
    public function testHasNotValue($subject, $value, $notExpected)
    {
        $hasNotValue = P\hasNotValue($value);

        $notExpected ? assertFalse($hasNotValue($subject)) : assertTrue($hasNotValue($subject));
    }

    public function hasValueDataProvider()
    {
        return [
            [['foo' => 'bar', 'bar' => 'baz'], 'bar', true],
            [['foo' => 'bar', 'bar' => 'baz'], 'baz', true],
            [['foo' => 'bar', 'bar' => 'baz'], 'foo', false],
            [['foo' => 'bar', 'bar' => 'baz'], ['baz'], false],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], 'bar', true],
            [(object) ['foo' => 'bar', 'bar' => ['baz']], ['baz'], true],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], 'foo', false],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], ['baz'], false],
            [new \ArrayObject(['foo' => 'bar', 'bar' => 'baz']), 'bar', true],
            [new \ArrayObject(['foo' => 'bar', 'bar' => false]), false, true],
            [new \ArrayObject(['foo' => 'bar', 'bar' => 'baz']), 'foo', false],
            [new \ArrayObject(['foo' => 'bar', 'bar' => 'baz']), ['baz'], false],
        ];
    }

    /**
     * @dataProvider hasValuesDataProvider
     * @param array|object $subject
     * @param array        $values
     * @param              $expected
     */
    public function testHasValues($subject, array $values, $expected)
    {
        $hasValues = P\hasValues($values);

        $expected ? assertTrue($hasValues($subject)) : assertFalse($hasValues($subject));
    }

    /**
     * @dataProvider hasValuesDataProvider
     * @param array|object $subject
     * @param array        $values
     * @param              $notExpected
     */
    public function testHasNotValues($subject, array $values, $notExpected)
    {
        $hasNotValues = P\hasNotValues($values);

        $notExpected ? assertFalse($hasNotValues($subject)) : assertTrue($hasNotValues($subject));
    }

    public function hasValuesDataProvider()
    {
        return [
            [['foo' => 'bar', 'bar' => 'baz'], ['bar'], true],
            [['foo' => 'bar', 'bar' => 'baz'], ['bar', 'baz'], true],
            [['bar', 'bar' => 'baz'], ['bar', 'baz'], true],
            [['bar', 'bar' => 'baz'], ['bar', 'baz', ''], false],
            [['foo', 'bar', 'baz'], ['foo', 'bar', 'baz'], true],
            [['foo', 'bar', 'baz'], ['foo', 'baz'], true],
            [['foo', 'bar', 'baz'], [0, 'foo', 'baz'], false],
            [['foo', 'bar', 'baz'], ['foo', ['baz']], false],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], ['bar'], true],
            [(object) ['foo' => 'bar', 'bar' => 'baz'], ['bar', 'baz'], true],
            [(object) ['a' => 'bar', 'bar' => 'baz'], ['bar', 'baz'], true],
            [(object) ['a' => 'bar', 'bar' => 'baz'], ['bar', 'baz', ''], false],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], ['foo', 'bar', 'baz'], true],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], ['foo', 'baz'], true],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], [0, 'foo', 'baz'], false],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], ['foo', ['baz']], false],
        ];
    }

    /**
     * @dataProvider hasAnyOfValuesDataProvider
     * @param array|object $subject
     * @param array        $values
     * @param              $expected
     */
    public function testHasAnyOfValues($subject, array $values, $expected)
    {
        $hasValues = P\hasAnyOfValues($values);

        $expected ? assertTrue($hasValues($subject)) : assertFalse($hasValues($subject));
    }

    /**
     * @dataProvider hasAnyOfValuesDataProvider
     * @param array|object $subject
     * @param array        $values
     * @param              $notExpected
     */
    public function testHasNotAnyOfValues($subject, array $values, $notExpected)
    {
        $hasNotValues = P\hasNotAnyOfValues($values);

        $notExpected ? assertFalse($hasNotValues($subject)) : assertTrue($hasNotValues($subject));
    }

    public function hasAnyOfValuesDataProvider()
    {
        return [
            [['foo', 'bar', 'baz'], ['foo'], true],
            [['foo', 'bar', 'baz'], ['foo', 'bar'], true],
            [['foo', 'bar', 'baz'], ['foo', 'bar', 'baz'], true],
            [['foo', 'bar', 'baz'], ['x', 'y', 'foo'], true],
            [['foo', 'bar', 'baz', []], ['x', 'y', []], true],
            [['foo', 'bar', 'baz'], ['x', 'y', []], false],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], ['foo'], true],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], ['foo', 'bar'], true],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], ['foo', 'bar', 'baz'], true],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], ['x', 'y', 'foo'], true],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz', 'd' => []], ['x', 'y', []], true],
            [(object) ['a' => 'foo', 'b' => 'bar', 'c' => 'baz'], ['x', 'y', []], false],
            [new \ArrayObject(['a' => 'foo', 'b' => 'bar', 'c' => 'baz']), ['foo'], true],
            [new \ArrayObject(['a' => 'foo', 'b' => 'bar', 'c' => 'baz']), ['foo', 'bar'], true],
        ];
    }
}
