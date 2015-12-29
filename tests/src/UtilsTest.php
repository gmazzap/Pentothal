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
use Pentothal\Stubs;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package Pentothal
 */
final class UtilsTest extends PHPUnit_Framework_TestCase
{

    public function testVariadicCall()
    {
        $function = function () {
            return func_get_args();
        };

        assertSame([], P\variadicCall($function, []));
        assertSame([true], P\variadicCall($function, [true]));
        assertSame([false], P\variadicCall($function, [false]));
        assertSame([false, true], P\variadicCall($function, [false, true]));
        assertSame([false, 0, 1], P\variadicCall($function, [false, 0, 1]));
        assertSame([false, 0, 1, []], P\variadicCall($function, [false, 0, 1, []]));
    }

    public function testVariadicCallNotEmpty()
    {
        $function = function () {
            $result = false;
            $args = func_get_args();
            foreach ($args as $arg) {
                $result = $arg;
            }

            return $result;
        };

        assertFalse(P\variadicCallNotEmpty($function, []));
        assertTrue(P\variadicCallNotEmpty($function, [true]));
        assertFalse(P\variadicCallNotEmpty($function, ['']));
        assertFalse(P\variadicCallNotEmpty($function, [false]));
        assertTrue(P\variadicCallNotEmpty($function, [false, true]));
        assertTrue(P\variadicCallNotEmpty($function, [false, 1]));
        assertFalse(P\variadicCallNotEmpty($function, [false, 0]));
        assertTrue(P\variadicCallNotEmpty($function, [false, 0, 1]));
        assertFalse(P\variadicCallNotEmpty($function, [false, 0, 1, []]));
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
            [(object)['a' => 'b', 'c' => 'd'], 1],
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
            [(object)['foo' => ['a', 'b', 'c']], 'foo', ['a', 'b', 'c']],
            [new \ArrayObject(['foo' => ['a', 'b', 'c']]), 'foo', ['a', 'b', 'c']],
        ];
    }

    public function testApplyOnClone()
    {
        $stub = new Stubs\Incrementable();
        $incremented1 = P\applyOnClone($stub, 'increment');
        $incremented3 = P\applyOnClone($stub, 'increment', [3]);

        assertSame(0, $stub->n);
        assertSame(1, $incremented1->n);
        assertSame(3, $incremented3->n);

    }
}