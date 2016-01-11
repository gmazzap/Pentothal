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
final class MapTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider combineMapDataProvider
     * @param array $subject
     * @param bool  $expected
     */
    public function testCombineMap($subject, $expected)
    {
        $map = [
            'name'   => 'is_string',
            'age'    => 'is_int',
            'accept' => 'is_bool',
        ];

        $combine = P\combineMap($map);

        $expected ? assertTrue($combine($subject)) : assertFalse($combine($subject));
    }

    public function combineMapDataProvider()
    {
        return [
            [['name' => 'Giuseppe', 'age' => 33, 'accept' => true], true],
            [['name' => 'John', 'age' => 20, 'accept' => 1], false],
            [['name' => 'Jane', 'age' => 0, 'accept' => false], true],
            [['full name' => 'John', 'age' => 20, 'accept' => true], false],
            [true, false],
        ];
    }

    /**
     * @dataProvider poolMapDataProvider
     * @param array $subject
     * @param bool  $expected
     */
    public function testPoolMap($subject, $expected)
    {
        $map = [
            'name'   => 'is_string',
            'age'    => 'is_int',
            'accept' => 'is_bool',
        ];

        $combine = P\poolMap($map);

        $expected ? assertTrue($combine($subject)) : assertFalse($combine($subject));
    }

    public function poolMapDataProvider()
    {
        return [
            [['name' => 'Giuseppe', 'age' => 33, 'accept' => true], true],
            [['name' => 'John', 'age' => 20, 'accept' => 1], true],
            [['name' => 1, 'age' => false, 'accept' => false], true],
            [['full name' => 0, 'age' => '', 'accept' => 1], false],
            [true, false],
        ];
    }
}
