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
final class FilterTest extends PHPUnit_Framework_TestCase
{

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
        $notIsEmail = P\isNotEmail();
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
        $notIsUrl = P\isNotUrl();
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
        $notIsIp = P\isNotIp();
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
        $notIsMac = P\isNotMac();
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