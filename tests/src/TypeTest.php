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
        $notIsType = P\notIsType($type);
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
        $notIsInt = P\notIsInt($value);
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
        $notIsFloat = P\notIsFloat($value);
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
        $notIsBool = P\notIsBool($value);
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
        $notIsNumber = P\notIsNumber($value);
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
        $notIsNull = P\notIsNull($value);
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
        $notIsString = P\notIsString($value);
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
        $notIsObject = P\notIsObject($value);
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
        $notIsArray = P\notIsArray($value);
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

    /**
     * @dataProvider stringsTypesDataProvider
     * @param string $value
     * @param string $type
     */
    public function testIsEmail($value, $type)
    {
        $isEmail = P\isEmail();
        $type === 'email' ? assertTrue($isEmail($value)) : assertFalse($isEmail($value));
    }

    /**
     * @dataProvider stringsTypesDataProvider
     * @param string $value
     * @param string $type
     */
    public function testNotIsEmail($value, $type)
    {
        $notIsEmail = P\notIsEmail();
        $type === 'email' ? assertFalse($notIsEmail($value)) : assertTrue($notIsEmail($value));
    }

    /**
     * @dataProvider stringsTypesDataProvider
     * @param string $value
     * @param string $type
     */
    public function testIsUrl($value, $type)
    {
        $isUrl = P\isUrl();
        $type === 'url' ? assertTrue($isUrl($value)) : assertFalse($isUrl($value));
    }

    /**
     * @dataProvider stringsTypesDataProvider
     * @param string $value
     * @param string $type
     */
    public function testNotIsUrl($value, $type)
    {
        $notIsUrl = P\notIsUrl();
        $type === 'url' ? assertFalse($notIsUrl($value)) : assertTrue($notIsUrl($value));
    }

    /**
     * @dataProvider stringsTypesDataProvider
     * @param string $value
     * @param string $type
     */
    public function testIsIp($value, $type)
    {
        $isIp = P\isIp();
        $type === 'ip' ? assertTrue($isIp($value)) : assertFalse($isIp($value));
    }

    /**
     * @dataProvider stringsTypesDataProvider
     * @param string $value
     * @param string $type
     */
    public function testNotIsIp($value, $type)
    {
        $notIsIp = P\notIsIp();
        $type === 'ip' ? assertFalse($notIsIp($value)) : assertTrue($notIsIp($value));
    }

    /**
     * @dataProvider stringsTypesDataProvider
     * @param string $value
     * @param string $type
     */
    public function testIsMac($value, $type)
    {
        $isMac = P\isMac();
        $type === 'mac' ? assertTrue($isMac($value)) : assertFalse($isMac($value));
    }

    /**
     * @dataProvider stringsTypesDataProvider
     * @param string $value
     * @param string $type
     */
    public function testNotIsMac($value, $type)
    {
        $notIsMac = P\notIsMac();
        $type === 'mac' ? assertFalse($notIsMac($value)) : assertTrue($notIsMac($value));
    }

    public function stringsTypesDataProvider()
    {
        return [
            [1, '---'],
            ['1', '---'],
            [1.1, '---'],
            [true, '---'],
            [new \stdClass(), '---'],
            [['foo@bar.it'], '---'],
            [['127.0.0.1'], '---'],
            ['foo@bar.it', 'email'],
            [' foo@bar.it', '---'],
            ['127.0.0.1', 'ip'],
            ['192.168.1.1', 'ip'],
            ['2001:0db8:0a0b:12f0:0000:0000:0000:0001', 'ip'],
            ['127.0.0.1:8080', '---'],
            ['http://127.0.0.1', 'url'],
            ['http://www.example.com', 'url'],
            ['https://www.example.com', 'url'],
            ['//www.example.com', 'url'],
            ['https://username:secret@www.example.com:8080/foo/bar/baz.html', 'url'],
            ['ftp://username:secret@www.example.com', 'url'],
            ['www.example.com', '---'],
            ['example.com', '---'],
            ['http://127.0.0.1:8080', 'url'],
            ['!def!xyz%abc@example.com', 'email'],
            ['customer/department=shipping@example.com', 'email'],
            ['!def!xyz@abc@example.com', '---'],
            ['21-8C-CD-F2-4B-EF', 'mac'],
            ['98:12:8a:8d:1e:96', 'mac'],
            ['98:12:8a:8d:1e:967', '---'],
            ['98:12:8x:8d:1e:96', '---'],
            ['21-8C-CD-F2-4B-EF-22', '---'],
            ['98:12:8a:8d:1e:96:96', '---'],

        ];
    }
}