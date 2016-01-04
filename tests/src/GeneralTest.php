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
final class GeneralTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testAlways($value)
    {
        $test = P\always();

        assertTrue($test($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNever($value)
    {
        /** @var \Closure $test */
        $test = P\never();

        assertFalse($test($value));
    }

    public function mixedDataProvider()
    {
        return [
            [[true]],
            [[false]],
            [[true, false]],
            [[true, true]],
            [[false, false]],
            ['foo'],
            [[]],
            [new \stdClass()],
            [1],
            [0],
            [null]
        ];
    }

    /**
     * @dataProvider negateDataProvider
     * @param mixed $value
     * @param bool  $expected
     */
    public function testNegate($value, $expected)
    {
        $pass = function ($arg) {
            return $arg;
        };

        $negate = P\negate($pass);
        $expected ? assertTrue($negate($value)) : assertFalse($negate($value));
    }

    public function negateDataProvider()
    {
        return [
            [true, false],
            [false, true],
            ['', true],
            [0, true],
            [null, true],
            [1, false],
        ];
    }

    /**
     * @dataProvider sameDataProvider
     * @param mixed $value
     * @param mixed $compare
     * @param bool  $expected
     */
    public function testIsSame($value, $compare, $expected)
    {
        $same = P\isSame($value);
        $expected ? assertTrue($same($compare)) : assertFalse($same($compare));
    }

    /**
     * @dataProvider sameDataProvider
     * @param mixed $value
     * @param mixed $compare
     * @param bool  $notExpected
     */
    public function testIsNotSame($value, $compare, $notExpected)
    {
        $same = P\isNotSame($value);
        $notExpected ? assertFalse($same($compare)) : assertTrue($same($compare));
    }

    public function sameDataProvider()
    {
        $obj = new \stdClass();

        return [
            [true, true, true],
            [true, false, false],
            [true, 1, false],
            [true, 'true', false],
            [$obj, $obj, true],
            [$obj, clone $obj, false],
            [['foo'], ['foo'], true],
            [['foo'], ['foo', 'bar'], false],
        ];
    }

    /**
     * @dataProvider equalDataProvider
     * @param mixed $value
     * @param mixed $compare
     * @param bool  $expected
     */
    public function testIsEqual($value, $compare, $expected)
    {
        $equal = P\isEqual($value);
        $expected ? assertTrue($equal($compare)) : assertFalse($equal($compare));
    }

    /**
     * @dataProvider equalDataProvider
     * @param mixed $value
     * @param mixed $compare
     * @param bool  $notExpected
     */
    public function testIsNotEqual($value, $compare, $notExpected)
    {
        $notEqual = P\isNotEqual($value);
        $notExpected ? assertFalse($notEqual($compare)) : assertTrue($notEqual($compare));
    }

    public function equalDataProvider()
    {
        $obj = new \stdClass();

        return [
            [true, true, true],
            [true, false, false],
            [true, 1, true],
            [true, 'true', true],
            [false, '', true],
            [false, 0, true],
            [$obj, $obj, true],
            [$obj, clone $obj, true],
            ['foo', 'foo', true],
            ['foo', 'foo ', false],
            [['foo'], ['foo'], true],
            [['foo'], ['foo', 'bar'], false],
        ];
    }

    /**
     * @dataProvider emptyDataProvider
     * @param mixed $value
     * @param bool  $expected
     */
    public function testIsEmpty($value, $expected)
    {
        /** @var \Closure $empty */
        $empty = P\isEmpty();
        $expected ? assertTrue($empty($value)) : assertFalse($empty($value));
    }

    /**
     * @dataProvider emptyDataProvider
     * @param mixed $value
     * @param bool  $notExpected
     */
    public function testIsNotEmpty($value, $notExpected)
    {
        /** @var \Closure $empty */
        $notEmpty = P\isNotEmpty();
        $notExpected ? assertFalse($notEmpty($value)) : assertTrue($notEmpty($value));
    }

    public function emptyDataProvider()
    {
        return [
            [true, false],
            ['x', false],
            [[''], false],
            [' ', false],
            [0.1, false],
            [new \stdClass(), false],
            [false, true],
            ['', true],
            [[], true],
            [0, true],
        ];
    }
}