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
final class MiscTest extends PHPUnit_Framework_TestCase
{

    public function testNestedPoolCombine()
    {
        $countableOne = new \ArrayObject(['foo' => 'bar']);
        $countableTwo = new \ArrayObject(['a' => 'a', 'b' => 'b']);
        $plainObj = new \stdClass();
        $string1 = 'a';
        $string3 = 'abc';
        $number1 = 1;
        $number3 = 3;

        $filter = P\combine(
            P\pool(P\isNotObject(), P\isType('Countable')), // filter out: $plainObj
            P\pool(P\isNotString(), P\size(3)), // filter out: $string1
            P\pool(P\isString(), P\size(1)) // filter out: $countableTwo, $number3
        );

        $list = [
            'a' => $countableOne,
            'b' => $countableTwo, // filtered out
            'c' => $plainObj, // filtered out
            'd' => $string1, // filtered out
            'e' => $string3,
            'f' => $number1,
            'g' => $number3 // filtered out
        ];

        $expectedIn = [
            'a' => $countableOne,
            'e' => $string3,
            'f' => $number1,
        ];

        $expectedOut = [
            'b' => $countableTwo,
            'c' => $plainObj,
            'd' => $string1,
            'g' => $number3
        ];

        assertSame($expectedIn, array_filter($list, $filter));
        assertSame($expectedOut, array_filter($list, P\negate($filter)));
    }
}