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
 * @param int $size
 * @return \Closure
 */
function size($size)
{
    if (! is_numeric($size)) {
        return never();
    }

    return function ($value) use ($size) {
        return polymorphicSize($value) === (int) $size;
    };
}

/**
 * @param int $max
 * @return \Closure
 */
function sizeMax($max)
{
    if (! is_numeric($max)) {
        return never();
    }

    return function ($value) use ($max) {
        $size = polymorphicSize($value);

        return is_int($size) && $size <= (int) $max;
    };
}

/**
 * @param int $max
 * @return \Closure
 */
function sizeMaxStrict($max)
{
    if (! is_numeric($max)) {
        return never();
    }

    return function ($value) use ($max) {
        $size = polymorphicSize($value);

        return is_int($size) >= 0 && $size < (int) $max;
    };
}

/**
 * @param int $min
 * @return \Closure
 */
function sizeMin($min)
{
    if (! is_numeric($min)) {
        return never();
    }

    return function ($value) use ($min) {
        $size = polymorphicSize($value);

        return is_int($size) >= 0 && $size >= (int) $min;
    };
}

/**
 * @param int $min
 * @return \Closure
 */
function sizeMinStrict($min)
{
    if (! is_numeric($min)) {
        return never();
    }

    return function ($value) use ($min) {
        $size = polymorphicSize($value);

        return is_int($size) && $size > (int) $min;
    };
}

/**
 * @param int $min
 * @param int $max
 * @return \Closure
 */
function between($min, $max)
{
    return combine(sizeMin($min), sizeMax($max));
}

/**
 * @param int $min
 * @param int $max
 * @return \Closure
 */
function notBetween($min, $max)
{
    return negate(between($min, $max));
}

/**
 * @param int $min
 * @param int $max
 * @return \Closure
 */
function betweenInner($min, $max)
{
    return combine(sizeMinStrict($min), sizeMaxStrict($max));
}

/**
 * @param int $min
 * @param int $max
 * @return \Closure
 */
function notBetweenInner($min, $max)
{
    return negate(betweenInner($min, $max));
}

/**
 * @param int $min
 * @param int $max
 * @return \Closure
 */
function betweenLeft($min, $max)
{
    return combine(sizeMin($min), sizeMaxStrict($max));
}

/**
 * @param int $min
 * @param int $max
 * @return \Closure
 */
function notBetweenLeft($min, $max)
{
    return negate(betweenLeft($min, $max));
}

/**
 * @param int $min
 * @param int $max
 * @return \Closure
 */
function betweenRight($min, $max)
{
    return combine(sizeMinStrict($min), sizeMax($max));
}

/**
 * @param int $min
 * @param int $max
 * @return \Closure
 */
function notBetweenRight($min, $max)
{
    return negate(betweenRight($min, $max));
}
