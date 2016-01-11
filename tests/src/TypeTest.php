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
final class TypeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider isTypeProvider
     * @param string $type
     * @param mixed  $value
     * @param bool   $expected
     */
    public function testIsType($type, $value, $expected)
    {
        /** @var \Closure $isType */
        $isType = P\isType($type);
        $expected ? assertTrue($isType($value)) : assertFalse($isType($value));
    }

    /**
     * @dataProvider isTypeProvider
     * @param string $type
     * @param mixed  $value
     * @param bool   $notExpected
     */
    public function testNotIsType($type, $value, $notExpected)
    {
        /** @var \Closure $notIsType */
        $notIsType = P\isNotType($type);
        $notExpected ? assertFalse($notIsType($value)) : assertTrue($notIsType($value));
    }

    public function isTypeProvider()
    {
        return [
            ['string', '', true],
            ['string', false, false],
            ['int', 1, true],
            ['int', true, false],
            ['int', 1.1, false],
            ['float', 1, false],
            ['float', true, false],
            ['float', 1.1, true],
            ['bool', 1, false],
            ['bool', 'true', false],
            ['bool', true, true],
            ['null', 1, false],
            ['null', '', false],
            ['null', false, false],
            ['null', null, true],
            ['array', 'a,b', false],
            ['array', ['a', 'b'], true],
            ['array', new \ArrayObject(), false],
            ['object', new \ArrayObject(), true],
            [new \ArrayObject(), new \ArrayObject(), true],
            ['ArrayObject', new \ArrayObject(), true],
            ['Pentothal\ArrayObject', new \ArrayObject(), false],
            [true, true, false],
        ];
    }

    /**
     * @dataProvider matchDataProvider
     * @param string $regex
     * @param mixed  $value
     * @param bool   $expected
     */
    public function testMatch($regex, $value, $expected)
    {
        /** @var \Closure $match */
        $match = P\match($regex);
        $expected ? assertTrue($match($value)) : assertFalse($match($value));
    }

    /**
     * @dataProvider matchDataProvider
     * @param string $regex
     * @param mixed  $value
     * @param bool   $notExpected
     */
    public function testNotMatch($regex, $value, $notExpected)
    {
        /** @var \Closure $notMatch */
        $notMatch = P\notMatch($regex);
        $notExpected ? assertFalse($notMatch($value)) : assertTrue($notMatch($value));
    }

    public function matchDataProvider()
    {
        return [
            [['/.+/'], 'foo', false],
            ['/.+/', 1, false],
            ['/.+/', 'foo', true],
            ['.+', 'foo', true],
            ['/[0-9]+/', '1', true],
            ['[0-9]+', '1', true],
            ['/[0-9]+', '1', false],
            ['[0-9]{3}', '3', false],
            ['[0-9]{3}', '333', true],
            ['^foo', 'foo', true],
            ['^foo|^bar', 'foo', true],
            ['^foo|^bar', 'bar', true],
            ['^foo|^bar', '-bar', false],
            ['^foo', ' foo', false],
            ['/^foo/', 'foo', true],
            ['/^foo/', ' foo', false],
            ['~/foo~', 'foo', false],
            ['~/foo~', '/foo', true],
        ];
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testIsInt($value)
    {
        $isInt = P\isInt($value);
        \is_int($value) ? assertTrue($isInt($value)) : assertFalse($isInt($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNotIsInt($value)
    {
        $notIsInt = P\isNotInt($value);
        \is_int($value) ? assertFalse($notIsInt($value)) : assertTrue($notIsInt($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testIsFloat($value)
    {
        $isFloat = P\isFloat($value);
        \is_float($value) ? assertTrue($isFloat($value)) : assertFalse($isFloat($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNotIsFloat($value)
    {
        $notIsFloat = P\isNotFloat($value);
        \is_float($value) ? assertFalse($notIsFloat($value)) : assertTrue($notIsFloat($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testIsBool($value)
    {
        $isBool = P\isBool($value);
        \is_bool($value) ? assertTrue($isBool($value)) : assertFalse($isBool($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNotIsBool($value)
    {
        $notIsBool = P\isNotBool($value);
        \is_bool($value) ? assertFalse($notIsBool($value)) : assertTrue($notIsBool($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testIsNumber($value)
    {
        $isNumber = P\isNumber($value);
        \is_numeric($value) ? assertTrue($isNumber($value)) : assertFalse($isNumber($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNotIsNumber($value)
    {
        $notIsNumber = P\isNotNumber($value);
        \is_numeric($value) ? assertFalse($notIsNumber($value)) : assertTrue($notIsNumber($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testIsNull($value)
    {
        /** @var callable $isNull */
        $isNull = P\isNull($value);
        \is_null($value) ? assertTrue($isNull($value)) : assertFalse($isNull($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNotIsNull($value)
    {
        $notIsNull = P\isNotNull($value);
        \is_null($value) ? assertFalse($notIsNull($value)) : assertTrue($notIsNull($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testIsString($value)
    {
        /** @var callable $isString */
        $isString = P\isString($value);
        \is_string($value) ? assertTrue($isString($value)) : assertFalse($isString($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNotIsString($value)
    {
        $notIsString = P\isNotString($value);
        \is_string($value) ? assertFalse($notIsString($value)) : assertTrue($notIsString($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testIsObject($value)
    {
        /** @var callable $isObject */
        $isObject = P\isObject($value);
        \is_object($value) ? assertTrue($isObject($value)) : assertFalse($isObject($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNotIsObject($value)
    {
        $notIsObject = P\isNotObject($value);
        \is_object($value) ? assertFalse($notIsObject($value)) : assertTrue($notIsObject($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testIsArray($value)
    {
        /** @var callable $isArray */
        $isArray = P\isArray($value);
        \is_array($value) ? assertTrue($isArray($value)) : assertFalse($isArray($value));
    }

    /**
     * @dataProvider mixedDataProvider
     * @param $value
     */
    public function testNotIsArray($value)
    {
        $notIsArray = P\isNotArray($value);
        \is_array($value) ? assertFalse($notIsArray($value)) : assertTrue($notIsArray($value));
    }

    public function mixedDataProvider()
    {
        return [
            [1],
            ['1'],
            [1.1],
            [true],
            [''],
            [new Stubs\CountThree()],
            [[]],
            [null],
            [[1, '']],
        ];
    }
}
