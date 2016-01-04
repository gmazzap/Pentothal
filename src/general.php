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
 * @param callable $callable
 * @return \Closure
 */
function negate(callable $callable)
{
    return function ($value) use ($callable) {
        return ! variadicCallBoolVal($callable, func_get_args());
    };
}


/**
 * @param mixed $compare
 * @return \Closure
 */
function isSame($compare)
{
    return function ($value) use ($compare) {
        return $value === $compare;
    };
}

/**
 * @param mixed $compare
 * @return \Closure
 */
function isNotSame($compare)
{
    return negate(isSame($compare));
}

/**
 * @param $compare
 * @return \Closure
 */
function isEqual($compare)
{
    return function ($value) use ($compare) {
        return $value == $compare;
    };
}

/**
 * @param $compare
 * @return \Closure
 */
function isNotEqual($compare)
{
    return negate(isEqual($compare));
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
