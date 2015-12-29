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
final class CombineTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider combineDataProvider
     * @param $str
     * @param $expected
     */
    public function testCombineCallbacks($str, $expected)
    {
        $isThreeChars = function ($value) {
            return strlen($value) === 3;
        };

        $startWithA = function ($value) {
            return strpos($value, 'a') === 0;
        };

        $endWithA = function ($value) {
            return substr($value, -1, 1) === 'a';
        };

        $test = P\combineCallbacks([
            'foo', // ignored,
            'is_string',
            $isThreeChars,
            $startWithA,
            1, // ignored
            $isThreeChars,
            $endWithA,
        ]);

        $expected ? assertTrue($test($str)) : assertFalse($test($str));
    }

    /**
     * @dataProvider combineDataProvider
     * @param $str
     * @param $expected
     */
    public function testCombine($str, $expected)
    {
        $isThreeChars = function ($value) {
            return strlen($value) === 3;
        };

        $startWithA = function ($value) {
            return strpos($value, 'a') === 0;
        };

        $endWithA = function ($value) {
            return substr($value, -1, 1) === 'a';
        };

        $test = P\combine(
            'foo', // ignored,
            'is_string',
            $isThreeChars,
            $startWithA,
            1, // ignored
            $isThreeChars,
            $endWithA
        );

        $expected ? assertTrue($test($str)) : assertFalse($test($str));
    }

    public function combineDataProvider()
    {
        return [
            ['', false],
            ['aaa', true],
            ['aaaa', false],
            [['a', 'a', 'a'], false],
            ['a a', true],
            ['aa', false],
            [new Stubs\Aaa(), false]
        ];
    }

    /**
     * @dataProvider combineFactoryDataProvider
     * @param array $array
     * @param bool  $expected
     */
    public function testCombineFactory($array, $expected)
    {
        $factory = function ($value) {
            return function (array $array) use ($value) {
                return in_array($value, $array, true);
            };
        };

        $test = P\combineFactory(['a', 'b', 'c'], $factory);

        $expected ? assertTrue($test($array)) : assertFalse($test($array));
    }

    public function combineFactoryDataProvider()
    {
        return [
            [['a'], false],
            [['a', 'b'], false],
            [['a', 'b', 'c'], true],
            [['a', 'b', 'c', 'd'], true],
            [['a', 'b', 'd'], false],
        ];
    }

    /**
     * @dataProvider poolDataProvider
     * @param $str
     * @param $expected
     */
    public function testPoolCallbacks($str, $expected)
    {
        $isThreeChars = function ($value) {
            return is_string($value) && strlen($value) === 3;
        };

        $startWithA = function ($value) {
            return is_string($value) && strpos($value, 'a') === 0;
        };

        $endWithA = function ($value) {
            return is_string($value) && substr($value, -1, 1) === 'a';
        };

        $test = P\poolCallbacks([
            'foo', // ignored,
            $isThreeChars,
            $startWithA,
            1, // ignored
            $isThreeChars,
            $endWithA,
        ]);

        $expected ? assertTrue($test($str)) : assertFalse($test($str));
    }

    /**
     * @dataProvider poolDataProvider
     * @param $str
     * @param $expected
     */
    public function testPool($str, $expected)
    {
        $isThreeChars = function ($value) {
            return is_string($value) && strlen($value) === 3;
        };

        $startWithA = function ($value) {
            return is_string($value) && strpos($value, 'a') === 0;
        };

        $endWithA = function ($value) {
            return is_string($value) && substr($value, -1, 1) === 'a';
        };

        $test = P\pool(
            'foo', // ignored,
            $isThreeChars,
            $startWithA,
            1, // ignored
            $isThreeChars,
            $endWithA
        );

        $expected ? assertTrue($test($str)) : assertFalse($test($str));
    }

    public function poolDataProvider()
    {
        return [
            ['xx', false],
            ['aabxx', true],
            ['baaa', true],
            [['a', 'a', 'a'], false],
            ['xyz', true],
            ['aa', true],
            [new Stubs\Aaa(), false]
        ];
    }

    /**
     * @dataProvider poolFactoryDataProvider
     * @param int  $int
     * @param bool $expected
     */
    public function testPoolFactory($int, $expected)
    {
        $factory = function (array $minMax) {
            return function ($number) use ($minMax) {
                return $number > $minMax[0] && $number < $minMax[1];
            };
        };

        $cases = [
            [0, 10],
            [50, 60],
            [900, 1000],
        ];

        $test = P\poolFactory($cases, $factory);

        $expected ? assertTrue($test($int)) : assertFalse($test($int));
    }

    public function poolFactoryDataProvider()
    {
        return [
            [-1, false],
            [53, true],
            [2000, false],
            [7, true],
            [40, false],
            [950, true],
            [70, false],
        ];
    }

}