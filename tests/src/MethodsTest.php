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
final class MethodsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider hasMethodDataProvider
     * @param mixed  $subject
     * @param string $method
     * @param bool   $expected
     */
    public function testHasMethod($subject, $method, $expected)
    {
        $hasMethod = P\hasMethod($method);

        $expected ? assertTrue($hasMethod($subject)) : assertFalse($hasMethod($subject));
    }

    /**
     * @dataProvider hasMethodDataProvider
     * @param mixed  $subject
     * @param string $method
     * @param bool   $notExpected
     */
    public function testHasNotMethod($subject, $method, $notExpected)
    {
        $hasMethod = P\hasNotMethod($method);

        $notExpected ? assertFalse($hasMethod($subject)) : assertTrue($hasMethod($subject));
    }

    public function hasMethodDataProvider()
    {
        return [
            [new \ArrayObject(), 'offsetExists', true],
            ['\ArrayObject', 'offsetExists', true],
            [new \ArrayObject(), 'get', false],
            [new \ArrayObject(), '', false],
            [[], '', false],
            ['', '', false],
        ];
    }

    /**
     * @dataProvider methodReturnDataProvider
     * @param string $method
     * @param mixed  $return
     * @param bool   $expected
     */
    public function testMethodReturn($method, $return, $expected)
    {
        $object = new Stubs\CountThree();
        $methodReturn = P\methodReturn($method, $return);

        $expected ? assertTrue($methodReturn($object)) : assertFalse($methodReturn($object));
    }

    /**
     * @dataProvider methodReturnDataProvider
     * @param string $method
     * @param mixed  $return
     * @param bool   $notExpected
     */
    public function testMethodNotReturn($method, $return, $notExpected)
    {
        $object = new Stubs\CountThree();
        $methodNotReturn = P\methodNotReturn($method, $return);

        $notExpected ? assertFalse($methodNotReturn($object)) : assertTrue($methodNotReturn($object));
    }

    public function methodReturnDataProvider()
    {
        return [
            ['foo', 3, false],
            ['count', 3, true],
            ['count', 2, false]
        ];
    }

    /**
     * @dataProvider methodReturnWithArgsDataProvider
     * @param \ArrayAccess $subject
     * @param string       $key
     * @param mixed        $value
     * @param bool         $expected
     */
    public function testMethodReturnWithArgs(\ArrayAccess $subject, $key, $value, $expected)
    {
        $return = P\methodReturn('offsetGet', $value, [$key]);

        $expected ? assertTrue($return($subject)) : assertFalse($return($subject));
    }

    public function methodReturnWithArgsDataProvider()
    {
        return [
            [new \ArrayObject(['foo' => 'bar']), 'foo', 'bar', true],
            [new \ArrayObject(['foo' => 'bar']), 'foo', 'baz', false],
            [new \ArrayObject(['foo' => 'bar']), 'bar', 'foo', false],
            [new \ArrayObject(['foo' => 'bar']), 'foo', 'foo', false],
            [new \ArrayObject(['foo', 'bar']), 'foo', 'foo', false],
            [new \ArrayObject(['a' => 'b', 'c' => 'd']), 'a', 'd', false],
            [new \ArrayObject(['a' => 'b', 'c' => 'd']), 'a', 'b', true],
        ];
    }

    /**
     * @dataProvider methodReturnAnyOfDataProvider
     * @param \ArrayAccess $subject
     * @param string       $key
     * @param array        $values
     * @param bool         $expected
     */
    public function testMethodReturnAnyOf(\ArrayAccess $subject, $key, array $values, $expected)
    {
        $return = P\methodReturnAnyOf('offsetGet', $values, [$key]);

        $expected ? assertTrue($return($subject)) : assertFalse($return($subject));
    }

    /**
     * @dataProvider methodReturnAnyOfDataProvider
     * @param \ArrayAccess $subject
     * @param string       $key
     * @param array        $values
     * @param bool         $notExpected
     */
    public function testMethodNotReturnAnyOf(
        \ArrayAccess $subject,
        $key,
        array $values,
        $notExpected
    ) {
        $notReturn = P\methodNotReturnAnyOf('offsetGet', $values, [$key]);

        $notExpected ? assertFalse($notReturn($subject)) : assertTrue($notReturn($subject));
    }

    public function methodReturnAnyOfDataProvider()
    {
        return [
            [new \ArrayObject(['foo' => 'bar']), 'foo', ['bar'], true],
            [new \ArrayObject(['foo' => 'bar']), 'foo', ['baz'], false],
            [new \ArrayObject(['foo' => 'bar']), 'foo', ['foo'], false],
            [new \ArrayObject(['foo' => 'bar']), 'bar', ['foo', 'bar'], false],
            [new \ArrayObject(['foo' => 'bar']), 'foo', ['foo', 'bar'], true],
            [new \ArrayObject(['a' => 'b', 'c' => 'd']), 'a', ['d'], false],
            [new \ArrayObject(['a' => 'b', 'c' => 'd']), 'a', ['a', 1, [], 'b'], true],
        ];
    }

    /**
     * @dataProvider methodReturnTypeDataProvider
     * @param \ArrayAccess $subject
     * @param string       $key
     * @param string       $type
     * @param bool         $expected
     */
    public function testMethodReturnType(\ArrayAccess $subject, $key, $type, $expected)
    {
        $return = P\methodReturnType('offsetGet', $type, [$key]);

        $expected ? assertTrue($return($subject)) : assertFalse($return($subject));
    }

    /**
     * @dataProvider methodReturnTypeDataProvider
     * @param \ArrayAccess $subject
     * @param string       $key
     * @param string       $type
     * @param bool         $notExpected
     */
    public function testNotMethodReturnType(\ArrayAccess $subject, $key, $type, $notExpected)
    {
        $notReturn = P\methodNotReturnType('offsetGet', $type, [$key]);

        $notExpected ? assertFalse($notReturn($subject)) : assertTrue($notReturn($subject));
    }

    public function methodReturnTypeDataProvider()
    {
        return [
            [new \ArrayObject(['foo' => 'bar']), 'foo', 'string', true],
            [new \ArrayObject(['foo' => 'bar']), 'bar', 'string', false],
            [new \ArrayObject(['foo' => 'bar']), 'foo', 'int', false],
            [new \ArrayObject(['foo' => 'bar']), 'foo', 'array', false],
            [new \ArrayObject(['foo' => ['bar']]), 'foo', 'array', true],
            [new \ArrayObject(['foo' => (object) ['bar']]), 'foo', 'object', true],
            [new \ArrayObject(['foo' => (object) ['bar']]), 'foo', '\stdClass', true],
        ];
    }

    /**
     * @dataProvider methodReturnEmptyDataProvider
     * @param string $key
     * @param bool   $expected
     */
    public function testMethodReturnEmpty($key, $expected)
    {
        $return = P\methodReturnEmpty('offsetGet', [$key]);

        $subject = new \ArrayObject(
            [
                'a' => '',
                'b' => 0,
                'c' => false,
                'd' => null,
                'e' => 'ok',
                'f' => true,
                'g' => 1,
            ]
        );

        $expected ? assertTrue($return($subject)) : assertFalse($return($subject));
    }

    /**
     * @dataProvider methodReturnEmptyDataProvider
     * @param string $key
     * @param bool   $notExpected
     */
    public function testMethodReturnNotEmpty($key, $notExpected)
    {
        $return = P\methodReturnNotEmpty('offsetGet', [$key]);

        $subject = new \ArrayObject(
            [
                'a' => '',
                'b' => 0,
                'c' => false,
                'd' => null,
                'e' => 'ok',
                'f' => true,
                'g' => 1,
            ]
        );

        $notExpected ? assertFalse($return($subject)) : assertTrue($return($subject));
    }

    public function methodReturnEmptyDataProvider()
    {
        return [
            ['a', true],
            ['b', true],
            ['c', true],
            ['d', true],
            ['e', false],
            ['f', false],
            ['g', false],
            ['h', true],
        ];
    }

    /**
     * @dataProvider methodReturnApplyDataProvider
     * @param string $key
     * @param bool   $expected
     */
    public function testMethodReturnApply($key, $expected)
    {
        $a = function ($value) {
            return $value === 'a';
        };

        $subject = new \ArrayObject(
            [
                'a' => '',
                'b' => 0,
                'c' => false,
                'd' => null,
                'e' => 'ok',
                'f' => true,
                'g' => 1,
                'h' => 'a',
            ]
        );

        $return = P\methodReturnApply('offsetGet', $a, [$key]);

        $expected ? assertTrue($return($subject)) : assertFalse($return($subject));
    }

    public function methodReturnApplyDataProvider()
    {
        return [
            ['a', false],
            ['b', false],
            ['c', false],
            ['d', false],
            ['e', false],
            ['f', false],
            ['g', false],
            ['h', true],
            ['i', false],
            ['l', false],
        ];
    }
}
