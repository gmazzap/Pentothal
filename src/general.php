<?php
/*
 * This file is part of the Pentothal package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pentothal;

/**
 * @return \Closure
 */
function always()
{
    return function () {
        return true;
    };
}

/**
 * @return \Closure
 */
function never()
{
    return function () {
        return false;
    };
}

/**
 * @return \Closure
 */
function isEmpty()
{
    return function ($value) {
        return empty($value);
    };
}

/**
 * @return \Closure
 */
function isNotEmpty()
{
    return negate(isEmpty());
}
