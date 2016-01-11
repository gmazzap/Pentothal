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
     * @dataProvider mapDataProvider
     * @param array|object $predicates
     * @param array|object $subject
     */
    public function testMap($predicates, $subject)
    {
        $expected = [
            'name'   => true,
            'email'  => true,
            'phone'  => false,
            'phone2' => true,
            'x'      => true,
        ];

        assertSame($expected, P\map($predicates, $subject));
    }

    /**
     * @dataProvider mapDataProvider
     * @param array|object $predicates
     * @param array|object $subject
     */
    public function testMapInverse($predicates, $subject)
    {
        $expected = [
            'name'   => false,
            'email'  => false,
            'phone'  => true,
            'phone2' => false,
            'x'      => false,
        ];

        assertSame($expected, P\mapInverse($predicates, $subject));
    }

    public function mapDataProvider()
    {
        return [
            [
                [
                    'name'   => P\combine(P\isString(), P\isNotEmpty()),
                    'email'  => P\isEmail(),
                    'phone'  => P\combine(P\isString(), P\startWith('+'), P\sizeMin(9)),
                    'phone2' => P\combine(P\isString(), P\startWith('+'), P\sizeMin(9)),
                    'meh'    => 'meh',
                ],
                (object) [
                    'name'   => 'John Doe',
                    'email'  => 'john.doe@johndoe.me',
                    'phone'  => '---',
                    'phone2' => '+ 123456789',
                    'x'      => '---',
                ],
            ],
            [
                new \ArrayObject([
                    'name'   => P\combine(P\isString(), P\isNotEmpty()),
                    'email'  => P\isEmail(),
                    'phone'  => P\combine(P\isString(), P\startWith('+'), P\sizeMin(9)),
                    'phone2' => P\combine(P\isString(), P\startWith('+'), P\sizeMin(9)),
                    'meh'    => 'meh',
                ]),
                [
                    'name'   => 'John Doe',
                    'email'  => 'john.doe@johndoe.me',
                    'phone'  => '---',
                    'phone2' => '+ 123456789',
                    'x'      => '---',
                ]
            ]
        ];
    }
}
