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
use Pentothal\Tests\Stubs;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package Pentothal
 */
final class SizeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider sizeDataProvider
     * @param      $value
     * @param      $size
     * @param bool $expected
     */
    public function testSize($value, $size, $expected)
    {
        $size = P\size($size);
        $expected ? assertTrue($size($value)) : assertFalse($size($value));
    }

    public function sizeDataProvider()
    {
        return [
            [12, 12, true],
            [12, '12', true],
            [12, 11, false],
            [12, '11', false],
            ['eleven', 11, false],
            ['eleven', 6, true],
            [['eleven'], 6, false],
            [['eleven'], 1, true],
            [['', '', ''], 3, true],
            [[1, 2, 3], 3, true],
            [['a' => 1, 'b' => 2, 'c' => 3], 3, true],
            [(object)['a' => 'b', 'b' => 'c'], 1, true],
            [(object)['a' => 'b', 'b' => 'c'], 2, false],
            [new \ArrayObject(['a' => 'b', 'b' => 'c']), 1, false],
            [new \ArrayObject(['a' => 'b', 'b' => 'c']), 2, true],
            [new Stubs\CountThree(), 3, true],
            [null, 0, true],
            [[], 0, true],
            [0, 0, true],
            [new \ArrayObject(), 0, true],
            [false, 0, true],
            [true, 1, true],
            [false, 1, false],
            [true, 0, false],
            [3, new Stubs\CountThree(), false],
            [3, ['', '', ''], false],
        ];
    }

    /**
     * @dataProvider maxDataProvider
     * @param      $value
     * @param int  $max
     * @param bool $expected
     */
    public function testMax($value, $max, $expected)
    {
        $sizeMax = P\sizeMax($max);
        $expected ? assertTrue($sizeMax($value)) : assertFalse($sizeMax($value));
    }

    public function maxDataProvider()
    {
        return [
            [10, 10, true],
            [10, 9, false],
            [10, 100, true],
            [10, -10, false],
            ['abc', 3, true],
            ['abc', 2, false],
            ['abc', 100, true],
            ['abc', -3, false],
            [['a', 'b', 'c'], 3, true],
            [['a', 'b', 'c'], 2, false],
            [['a', 'b', 'c'], 100, true],
            [['a', 'b', 'c'], -3, false],
            ['', 0, true],
            ['', -1, false],
            ['', 1, true],
            [[], 0, true],
            [[], -1, false],
            [[], 10, true],
            [null, 0, true],
            [null, -1, false],
            [null, 10, true],
            [new Stubs\CountThree(), 3, true],
            [new Stubs\CountThree(), 2, false],
            [new Stubs\CountThree(), 100, true],
            [new Stubs\CountThree(), -3, false],
            [new \stdClass(), 1, true],
            [new \stdClass(), 0, false],
            [new \stdClass(), 5, true],
            [5, 'five', false],
        ];
    }

    /**
     * @dataProvider maxStrictDataProvider
     * @param      $value
     * @param int  $max
     * @param bool $expected
     */
    public function testMaxStrict($value, $max, $expected)
    {
        $sizeMax = P\sizeMaxStrict($max);
        $expected ? assertTrue($sizeMax($value)) : assertFalse($sizeMax($value));
    }

    public function maxStrictDataProvider()
    {
        return [
            [10, 10, false],
            [10, 9, false],
            [10, 100, true],
            [10, -10, false],
            ['abc', 3, false],
            ['abc', 2, false],
            ['abc', 100, true],
            ['abc', -3, false],
            [['a', 'b', 'c'], 3, false],
            [['a', 'b', 'c'], 2, false],
            [['a', 'b', 'c'], 100, true],
            [['a', 'b', 'c'], -3, false],
            ['', 0, false],
            ['', -1, false],
            ['', 1, true],
            [[], 0, false],
            [[], -1, false],
            [[], 10, true],
            [null, 0, false],
            [null, -1, false],
            [null, 10, true],
            [new Stubs\CountThree(), 3, false],
            [new Stubs\CountThree(), 2, false],
            [new Stubs\CountThree(), 100, true],
            [new Stubs\CountThree(), -3, false],
            [new \stdClass(), 1, false],
            [new \stdClass(), 0, false],
            [new \stdClass(), 5, true],
            [5, 'five', false],
        ];
    }

    /**
     * @dataProvider minDataProvider
     * @param      $value
     * @param int  $min
     * @param bool $expected
     */
    public function testMin($value, $min, $expected)
    {
        $sizeMin = P\sizeMin($min);
        $expected ? assertTrue($sizeMin($value)) : assertFalse($sizeMin($value));
    }

    public function minDataProvider()
    {
        return [
            [10, 10, true],
            [10, 11, false],
            [10, 5, true],
            [10, -10, true],
            ['abc', 3, true],
            ['abc', 20, false],
            ['abc', 2, true],
            ['abc', 0, true],
            [['a', 'b', 'c'], 3, true],
            [['a', 'b', 'c'], 20, false],
            [['a', 'b', 'c'], 1, true],
            [['a', 'b', 'c'], -3, true],
            ['', 0, true],
            ['', 3, false],
            ['', -1, true],
            [[], 0, true],
            [[], 2, false],
            [[], -3, true],
            [null, 0, true],
            [null, 5, false],
            [null, -10, true],
            [new Stubs\CountThree(), 3, true],
            [new Stubs\CountThree(), 20, false],
            [new Stubs\CountThree(), -100, true],
            [new Stubs\CountThree(), -1, true],
            [new \stdClass(), 1, true],
            [new \stdClass(), 0, true],
            [new \stdClass(), 2, false],
            [5, 'five', false],
        ];
    }

    /**
     * @dataProvider minStrictDataProvider
     * @param      $value
     * @param int  $min
     * @param bool $expected
     */
    public function testMinStrict($value, $min, $expected)
    {
        $sizeMin = P\sizeMinStrict($min);
        $expected ? assertTrue($sizeMin($value)) : assertFalse($sizeMin($value));
    }

    public function minStrictDataProvider()
    {
        return [
            [10, 10, false],
            [10, 11, false],
            [10, 5, true],
            [10, -10, true],
            ['abc', 3, false],
            ['abc', 20, false],
            ['abc', 2, true],
            ['abc', 0, true],
            [['a', 'b', 'c'], 3, false],
            [['a', 'b', 'c'], 20, false],
            [['a', 'b', 'c'], 1, true],
            [['a', 'b', 'c'], -3, true],
            ['', 0, false],
            ['', 3, false],
            ['', -1, true],
            [[], 0, false],
            [[], 2, false],
            [[], -3, true],
            [null, 0, false],
            [null, 5, false],
            [null, -10, true],
            [new Stubs\CountThree(), 3, false],
            [new Stubs\CountThree(), 20, false],
            [new Stubs\CountThree(), -100, true],
            [new Stubs\CountThree(), -1, true],
            [new \stdClass(), 1, false],
            [new \stdClass(), 0, true],
            [new \stdClass(), 2, false],
            [5, 'five', false],
        ];
    }

    /**
     * @dataProvider betweenDataProvider
     * @param       $value
     * @param array $minMax
     * @param bool  $expected
     */
    public function testBetween($value, array $minMax, $expected)
    {
        $between = P\between($minMax[0], $minMax[1]);
        $expected ? assertTrue($between($value)) : assertFalse($between($value));
    }

    /**
     * @dataProvider betweenDataProvider
     * @param       $value
     * @param array $minMax
     * @param bool  $notExpected
     */
    public function testNotBetween($value, array $minMax, $notExpected)
    {
        $notBetween = P\notBetween($minMax[0], $minMax[1]);
        $notExpected ? assertFalse($notBetween($value)) : assertTrue($notBetween($value));
    }

    public function betweenDataProvider()
    {
        return [
            [10, [11, 20], false],
            [10, [5, 8], false],
            [10, [5, 20], true],
            [10, [5, 10], true],
            [10, [10, 20], true],
            ['foo', [4, 20], false],
            ['foo', [-1, 2], false],
            ['foo', [-1, 20], true],
            ['foo', [0, 3], true],
            ['foo', [3, 20], true],
            [new Stubs\CountThree(), [4, 20], false],
            [new Stubs\CountThree(), [-1, 2], false],
            [new Stubs\CountThree(), [-1, 20], true],
            [new Stubs\CountThree(), [0, 3], true],
            [new Stubs\CountThree(), [3, 20], true],
            [['a', 'b', 'c'], [4, 20], false],
            [['a', 'b', 'c'], [-1, 2], false],
            [['a', 'b', 'c'], [-1, 20], true],
            [['a', 'b', 'c'], [0, 3], true],
            [['a', 'b', 'c'], [3, 20], true],
        ];
    }

    /**
     * @dataProvider betweenInnerDataProvider
     * @param       $value
     * @param array $minMax
     * @param bool  $expected
     */
    public function testBetweenInner($value, array $minMax, $expected)
    {
        $between = P\betweenInner($minMax[0], $minMax[1]);
        $expected ? assertTrue($between($value)) : assertFalse($between($value));
    }

    /**
     * @dataProvider betweenInnerDataProvider
     * @param       $value
     * @param array $minMax
     * @param bool  $notExpected
     */
    public function testNotBetweenInner($value, array $minMax, $notExpected)
    {
        $between = P\notBetweenInner($minMax[0], $minMax[1]);
        $notExpected ? assertFalse($between($value)) : assertTrue($between($value));
    }

    public function betweenInnerDataProvider()
    {
        return [
            [10, [11, 20], false],
            [10, [5, 8], false],
            [10, [5, 20], true],
            [10, [5, 10], false],
            [10, [10, 20], false],
            ['foo', [4, 20], false],
            ['foo', [-1, 2], false],
            ['foo', [-1, 20], true],
            ['foo', [0, 3], false],
            ['foo', [3, 20], false],
            [new Stubs\CountThree(), [4, 20], false],
            [new Stubs\CountThree(), [-1, 2], false],
            [new Stubs\CountThree(), [-1, 20], true],
            [new Stubs\CountThree(), [0, 3], false],
            [new Stubs\CountThree(), [3, 20], false],
            [['a', 'b', 'c'], [4, 20], false],
            [['a', 'b', 'c'], [-1, 2], false],
            [['a', 'b', 'c'], [-1, 20], true],
            [['a', 'b', 'c'], [0, 3], false],
            [['a', 'b', 'c'], [3, 20], false],
        ];
    }

    /**
     * @dataProvider betweenLeftDataProvider
     * @param       $value
     * @param array $minMax
     * @param bool  $expected
     */
    public function testBetweenLeft($value, array $minMax, $expected)
    {
        $between = P\betweenLeft($minMax[0], $minMax[1]);
        $expected ? assertTrue($between($value)) : assertFalse($between($value));
    }

    /**
     * @dataProvider betweenLeftDataProvider
     * @param       $value
     * @param array $minMax
     * @param bool  $notExpected
     */
    public function testNotBetweenLeft($value, array $minMax, $notExpected)
    {
        $between = P\notBetweenLeft($minMax[0], $minMax[1]);
        $notExpected ? assertFalse($between($value)) : assertTrue($between($value));
    }

    public function betweenLeftDataProvider()
    {
        return [
            [10, [11, 20], false],
            [10, [5, 8], false],
            [10, [5, 20], true],
            [10, [5, 10], false],
            [10, [10, 20], true],
            ['foo', [4, 20], false],
            ['foo', [-1, 2], false],
            ['foo', [-1, 20], true],
            ['foo', [0, 3], false],
            ['foo', [3, 20], true],
            [new Stubs\CountThree(), [4, 20], false],
            [new Stubs\CountThree(), [-1, 2], false],
            [new Stubs\CountThree(), [-1, 20], true],
            [new Stubs\CountThree(), [0, 3], false],
            [new Stubs\CountThree(), [3, 20], true],
            [['a', 'b', 'c'], [4, 20], false],
            [['a', 'b', 'c'], [-1, 2], false],
            [['a', 'b', 'c'], [-1, 20], true],
            [['a', 'b', 'c'], [0, 3], false],
            [['a', 'b', 'c'], [3, 20], true],
        ];
    }

    /**
     * @dataProvider betweenRightDataProvider
     * @param       $value
     * @param array $minMax
     * @param bool  $expected
     */
    public function testBetweenRight($value, array $minMax, $expected)
    {
        $between = P\betweenRight($minMax[0], $minMax[1]);
        $expected ? assertTrue($between($value)) : assertFalse($between($value));
    }

    /**
     * @dataProvider betweenRightDataProvider
     * @param       $value
     * @param array $minMax
     * @param bool  $notExpected
     */
    public function testNotBetweenRight($value, array $minMax, $notExpected)
    {
        $between = P\notBetweenRight($minMax[0], $minMax[1]);
        $notExpected ? assertFalse($between($value)) : assertTrue($between($value));
    }

    public function betweenRightDataProvider()
    {
        return [
            [10, [11, 20], false],
            [10, [5, 8], false],
            [10, [5, 20], true],
            [10, [5, 10], true],
            [10, [10, 20], false],
            ['foo', [4, 20], false],
            ['foo', [-1, 2], false],
            ['foo', [-1, 20], true],
            ['foo', [0, 3], true],
            ['foo', [3, 20], false],
            [new Stubs\CountThree(), [4, 20], false],
            [new Stubs\CountThree(), [-1, 2], false],
            [new Stubs\CountThree(), [-1, 20], true],
            [new Stubs\CountThree(), [0, 3], true],
            [new Stubs\CountThree(), [3, 20], false],
            [['a', 'b', 'c'], [4, 20], false],
            [['a', 'b', 'c'], [-1, 2], false],
            [['a', 'b', 'c'], [-1, 20], true],
            [['a', 'b', 'c'], [0, 3], true],
            [['a', 'b', 'c'], [3, 20], false],
        ];
    }

}