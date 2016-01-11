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
final class ContainTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider containDataProvider
     * @param mixed $value
     * @param mixed $item
     * @param bool  $expected
     */
    public function testContain($value, $item, $expected)
    {
        $contain = P\contain($item);
        $expected ? assertTrue($contain($value)) : assertFalse($contain($value));
    }

    /**
     * @dataProvider containDataProvider
     * @param mixed $value
     * @param mixed $item
     * @param bool  $notExpected
     */
    public function testNotContain($value, $item, $notExpected)
    {
        $notContain = P\notContain($item);
        $notExpected ? assertFalse($notContain($value)) : assertTrue($notContain($value));
    }

    public function containDataProvider()
    {
        $obj = new \stdClass();

        return [
            ['foobarbaz', 'bar', true],
            [['foo', 'bar', 'baz'], 'bar', true],
            ['foobarbaz', 'foo', true],
            [['foo', 'bar', 'baz'], 'foo', true],
            ['foobarbaz', 'baz', true],
            [['foo', 'bar', 'baz'], 'baz', true],
            ['foobarbaz', 'barx', false],
            [['foo', 'bar', 'baz'], 'barx', false],
            [['foo', 'bar', $obj], $obj, true],
            [['foo', 'bar', $obj], clone $obj, false],
            [['f' => 'foo', 'b' => 'bar', 'z' => 'baz'], 'bar', true],
            [['f' => 'foo', 'b' => 'bar', 'z' => 'baz'], 'foo', true],
            [['f' => 'foo', 'b' => 'bar', 'z' => 'baz'], 'baz', true],
            [['f' => 'foo', 'b' => 'bar', 'z' => 'baz'], 'barx', false],
            [['f' => 'foo', 'b' => 'bar', 'z' => $obj], $obj, true],
            [['f' => 'foo', 'b' => 'bar', 'z' => $obj], clone $obj, false],
            [[['foo'], ['bar'], ['baz']], ['foo'], true],
            [[['foo'], ['bar'], ['baz']], ['foobar'], false],
            ['', '', false],
            [new \stdClass(), '', false],
        ];
    }

    /**
     * @dataProvider startWithDataProvider
     * @param mixed $value
     * @param mixed $start
     * @param bool  $expected
     */
    public function testStartWith($value, $start, $expected)
    {
        $startWith = P\startWith($start);
        $expected ? assertTrue($startWith($value)) : assertFalse($startWith($value));
    }

    /**
     * @dataProvider startWithDataProvider
     * @param mixed $value
     * @param mixed $start
     * @param bool  $notExpected
     */
    public function testNotStartWith($value, $start, $notExpected)
    {
        $notStartWith = P\notStartWith($start);
        $notExpected ? assertFalse($notStartWith($value)) : assertTrue($notStartWith($value));
    }

    public function startWithDataProvider()
    {
        $obj = new \stdClass();

        return [
            ['abc', 'a', true],
            ['abc', 'b', false],
            ['abc', 'c', false],
            ['abc', '', false],
            ['abc', 'x', false],
            [[$obj, 'b', 'c'], $obj, true],
            [['a', $obj, 'c'], $obj, false],
            [[['a'], 'b', 'c'], ['a'], true],
            [['a', ['a'], 'c'], ['a'], false],
            [['a', 'b', 'c'], 'a', true],
            [['a', 'b', 'c'], 'b', false],
            [['a', 'b', 'c'], 'c', false],
            [['a', 'b', 'c'], '', false],
            [['a', 'b', 'c'], 'x', false],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], 'a', true],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], 'b', false],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], 'c', false],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], '', false],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], 'x', false],
            [(object) ['a', 'b', 'c'], 'a', false],
            [new Stubs\CountThree(), 3, false],
        ];
    }

    /**
     * @dataProvider endWithDataProvider
     * @param mixed $value
     * @param mixed $end
     * @param bool  $expected
     */
    public function testEndWith($value, $end, $expected)
    {
        $endWith = P\endWith($end);
        $expected ? assertTrue($endWith($value)) : assertFalse($endWith($value));
    }

    /**
     * @dataProvider endWithDataProvider
     * @param mixed $value
     * @param mixed $end
     * @param bool  $notExpected
     */
    public function testEndStartWith($value, $end, $notExpected)
    {
        $notEndWith = P\notEndWith($end);
        $notExpected ? assertFalse($notEndWith($value)) : assertTrue($notEndWith($value));
    }

    public function endWithDataProvider()
    {
        $obj = new \stdClass();

        return [
            ['abc', 'c', true],
            ['abc', 'b', false],
            ['abc', 'a', false],
            ['abc', '', false],
            ['abc', 'x', false],
            [['a', 'b', $obj], $obj, true],
            [['a', $obj, 'c'], $obj, false],
            [[['a'], 'b', ['c']], ['c'], true],
            [['a', ['a'], 'c'], ['a'], false],
            [['a', 'b', 'c'], 'c', true],
            [['a', 'b', 'c'], 'b', false],
            [['a', 'b', 'c'], 'a', false],
            [['a', 'b', 'c'], '', false],
            [['a', 'b', 'c'], 'x', false],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], 'c', true],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], 'b', false],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], 'a', false],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], '', false],
            [['a' => 'a', 'b' => 'b', 'c' => 'c'], 'x', false],
            [(object) ['a', 'b', 'c'], 'a', false],
            [new Stubs\CountThree(), 3, false],
        ];
    }

    /**
     * @dataProvider anyOfValuesDataProvider
     * @param       $value
     * @param array $items
     * @param       $expected
     */
    public function testAnyOfValues($value, array $items, $expected)
    {
        $any = P\anyOfValues($items);
        $expected ? assertTrue($any($value)) : assertFalse($any($value));
    }

    /**
     * @dataProvider anyOfValuesDataProvider
     * @param       $value
     * @param array $items
     * @param       $notExpected
     */
    public function testNotAnyOfValues($value, array $items, $notExpected)
    {
        $notAny = P\notAnyOfValues($items);
        $notExpected ? assertFalse($notAny($value)) : assertTrue($notAny($value));
    }

    public function anyOfValuesDataProvider()
    {
        $obj = new \stdClass();

        return [
            ['a', ['a', 'b', 'c'], true],
            ['b', ['a', 'b', 'c'], true],
            ['x', ['a', 'b', 'c'], false],
            [null, ['a', 'b', 'c'], false],
            [1, ['a', 1, 'c'], true],
            [1, ['a', 2, 'c'], false],
            [$obj, ['a', $obj, 'c'], true],
            [$obj, ['a', 'b', 'c'], false],
            [['a'], [['a'], 'b', 'c'], true],
            [['b'], [['a'], 'b', 'c'], false],
        ];
    }

    public function testAnyOf()
    {
        $obj = new \stdClass();

        $anyAbc = P\anyOf('a', 'b', 'c');
        $anyA1c = P\anyOf('a', 1, 'c');
        $anyA2c = P\anyOf('a', 2, 'c');
        $anyAObjC = P\anyOf('a', $obj, 'c');
        $anyArrBC = P\anyOf(['a'], 'b', 'c');

        assertTrue($anyAbc('a'));
        assertTrue($anyAbc('b'));
        assertTrue($anyAbc('c'));
        assertFalse($anyAbc(''));
        assertFalse($anyAbc($obj));
        assertTrue($anyA1c('a'));
        assertTrue($anyA1c(1));
        assertFalse($anyA1c(2));
        assertTrue($anyA1c('c'));
        assertTrue($anyA2c('a'));
        assertTrue($anyA2c(2));
        assertFalse($anyA2c(1));
        assertTrue($anyA2c('c'));
        assertTrue($anyAObjC('a'));
        assertFalse($anyAObjC('b'));
        assertTrue($anyAObjC('c'));
        assertTrue($anyAObjC($obj));
        assertFalse($anyAObjC(['a']));
        assertFalse($anyArrBC('a'));
        assertFalse($anyArrBC(['b']));
        assertTrue($anyArrBC('b'));
        assertTrue($anyArrBC('c'));
        assertFalse($anyArrBC($obj));
    }

    public function testNotAnyOf()
    {
        $obj = new \stdClass();

        $notAnyAbc = P\notAnyOf('a', 'b', 'c');
        $notAnyA1c = P\notAnyOf('a', 1, 'c');
        $notAnyA2c = P\notAnyOf('a', 2, 'c');
        $notAnyAObjC = P\notAnyOf('a', $obj, 'c');
        $notAnyArrBC = P\notAnyOf(['a'], 'b', 'c');

        assertFalse($notAnyAbc('a'));
        assertFalse($notAnyAbc('b'));
        assertFalse($notAnyAbc('c'));
        assertTrue($notAnyAbc(''));
        assertTrue($notAnyAbc($obj));
        assertFalse($notAnyA1c('a'));
        assertFalse($notAnyA1c(1));
        assertTrue($notAnyA1c(2));
        assertFalse($notAnyA1c('c'));
        assertFalse($notAnyA2c('a'));
        assertFalse($notAnyA2c(2));
        assertTrue($notAnyA2c(1));
        assertFalse($notAnyA2c('c'));
        assertFalse($notAnyAObjC('a'));
        assertTrue($notAnyAObjC('b'));
        assertFalse($notAnyAObjC('c'));
        assertFalse($notAnyAObjC($obj));
        assertTrue($notAnyAObjC(['a']));
        assertTrue($notAnyArrBC('a'));
        assertTrue($notAnyArrBC(['b']));
        assertFalse($notAnyArrBC('b'));
        assertFalse($notAnyArrBC('c'));
        assertTrue($notAnyArrBC($obj));
    }
}
