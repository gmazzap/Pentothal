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
final class ComparisonTest extends PHPUnit_Framework_TestCase
{
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
}
