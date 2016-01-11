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
final class UtilsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider variadicCallDataProvider
     * @param array $args
     */
    public function testVariadicCall($args)
    {
        $function = function () {
            return func_get_args();
        };

        assertSame($args, P\variadicCall($function, $args));
    }

    public function variadicCallDataProvider()
    {
        return [
            [[]],
            [[true]],
            [[false]],
            [[false, true]],
            [[false, 0, 1]],
            [[false, 0, 1, []]],
        ];
    }

    /**
     * @dataProvider variadicCallBoolValDataProvider
     * @param array $args
     * @param bool  $expected
     */
    public function testVariadicCallBoolVal($args, $expected)
    {
        $function = function () {
            $args = func_get_args();
            if (empty($args)) {
                return;
            }

            return array_pop($args);
        };

        $value = P\variadicCallBoolVal($function, $args);

        $expected ? assertTrue($value) : assertFalse($value);
    }

    public function variadicCallBoolValDataProvider()
    {
        return [
            [[], false],
            [[true], true],
            [[false], false],
            [[false, true], true],
            [[false, '1'], true],
            [[false, ''], false],
            [[false, 0, 'true'], true],
            [[false, 0, 1, []], false],
            [[false, 0, 1, [], (object) ['a' => 'b']], true],
        ];
    }

    /**
     * @dataProvider polymorphicSizeDataProvider
     * @param mixed $element
     * @param int   $expected
     */
    public function testPolymorphicSize($element, $expected)
    {
        assertSame($expected, P\polymorphicSize($element));
    }

    public function polymorphicSizeDataProvider()
    {
        return [
            ['abc', 3],
            [123, 123],
            [123.33, 123],
            [0.9999, 0],
            [new Stubs\CountThree(), 3],
            [['a', 1, [], null], 4],
            [(object) ['a' => 'b', 'c' => 'd'], 1],
            [[], 0],
            [null, 0],
            [new \ArrayObject(['foo', 'bar']), 2]
        ];
    }

    /**
     * @dataProvider polymorphicKeyValueDataProvider
     * @param $object
     * @param $key
     * @param $expected
     */
    public function testPolymorphicKeyValue($object, $key, $expected)
    {
        assertSame($expected, P\polymorphicKeyValue($object, $key));
    }

    public function polymorphicKeyValueDataProvider()
    {
        return [
            [['foo' => 'bar'], 'foo', 'bar'],
            [['foo' => ['a', 'b', 'c']], 'foo', ['a', 'b', 'c']],
            [(object) ['foo' => ['a', 'b', 'c']], 'foo', ['a', 'b', 'c']],
            [new \ArrayObject(['foo' => ['a', 'b', 'c']]), 'foo', ['a', 'b', 'c']],
        ];
    }

    public function testApplyOnClone()
    {
        $stub = new Stubs\Incrementable();
        $incremented1 = P\callOnClone($stub, 'increment');
        $incremented3 = P\callOnClone($stub, 'increment', [3]);

        assertSame(0, $stub->n);
        assertSame(1, $incremented1->n);
        assertSame(3, $incremented3->n);
    }
}
