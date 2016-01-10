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
 * @param string $regex
 * @return \Closure
 */
function match($regex)
{
    if (! is_string($regex) || $regex === '') {
        return never();
    }

    $first = substr($regex, 0, 1);
    $last = substr($regex, -1, 1);
    if (($first !== $last) || strlen($regex) === 1) {
        $regex = "/{$regex}/";
    }

    return function ($value) use ($regex) {
        return is_string($value) && @preg_match($regex, $value) === 1;
    };
}

/**
 * @param string $regex
 * @return \Closure
 */
function notMatch($regex)
{
    return negate(match($regex));
}
