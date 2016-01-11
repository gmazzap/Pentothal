<?php
/*
 * This file is part of the Pentothal package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pentothal\Tests\Stubs;

class CountThree implements \Countable
{
    public function count()
    {
        return 3;
    }
}

class Incrementable
{
    public $n = 0;

    public function increment($increment = 1)
    {
        $this->n += $increment;

        return $this;
    }
}

class Aaa
{
    public function __toString()
    {
        return 'aaa';
    }
}
