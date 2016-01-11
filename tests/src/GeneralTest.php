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
