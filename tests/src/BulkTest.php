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
final class BulkTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider bulkDataProvider
     * @param array    $array
     * @param callable $function
     * @param bool     $expected
     */
    public function testBulk($array, $function, $expected)
    {
        $bulk = P\bulk($function);
        $expected ? assertTrue($bulk($array)) : assertFalse($bulk($array));
    }

    public function bulkDataProvider()
    {
        return [
            [['a', 'b', 'c'], 'is_string', true],
            [['a', 1, 'c'], 'is_string', false],
            [[1, 2, 3], 'is_int', true],
            [[1, 2.0, 3], 'is_int', false],
            [[true, false, false], 'is_bool', true],
            [[true, false, 0], 'is_bool', false],
        ];
    }

    /**
     * @dataProvider bulkPoolDataProvider
     * @param array    $array
     * @param callable $function
     * @param bool     $expected
     */
    public function testBulkPool($array, $function, $expected)
    {
        $bulk = P\bulkPool($function);
        $expected ? assertTrue($bulk($array)) : assertFalse($bulk($array));
    }

    public function bulkPoolDataProvider()
    {
        return [
            [['a', 1, 2], 'is_string', true],
            [[1, 2, 3], 'is_string', false],
            [[1, 2.0, 3], 'is_int', true],
            [[1.1, 2.0, 3.0], 'is_int', false],
            [['a', 'b', 'c'], 'is_array', false],
            [['a', [], 'c'], 'is_array', true],
        ];
    }
}