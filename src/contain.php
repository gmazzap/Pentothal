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
 * @param $item
 * @return \Closure
 */
function contain($item)
{
    return function ($value) use ($item) {
        if (
            (! is_string($value) && ! is_array($value))
            || (is_string($value) && ! is_string($item))
            || empty($value)
        ) {
            return false;
        }

        if (is_array($value)) {
            return in_array($item, $value, true);
        }

        /** @var callable $strFunc */
        $strFunc = function_exists('mb_stripos') ? 'mb_stripos' : 'stripos';

        return $strFunc($value, $item) !== false;
    };
}

/**
 * @param $item
 * @return \Closure
 */
function notContain($item)
{
    return negate(contain($item));
}

/**
 * @param $start
 * @return \Closure
 */
function startWith($start)
{
    return function ($value) use ($start) {
        if (
            (! is_string($value) && ! is_array($value))
            || (is_string($value) && ! is_string($start))
            || empty($value)
        ) {
            return false;
        }

        if (is_array($value)) {
            return reset($value) === $start;
        }

        /** @var callable $strFunc */
        $strFunc = function_exists('mb_strcut') ? 'mb_strcut' : 'substr';

        return $strFunc($value, 0, 1) === $start;
    };
}

/**
 * @param $start
 * @return \Closure
 */
function notStartWith($start)
{
    return negate(startWith($start));
}

/**
 * @param $end
 * @return \Closure
 */
function endWith($end)
{
    return function ($value) use ($end) {
        if (
            (! is_string($value) && ! is_array($value))
            || (is_string($value) && ! is_string($end))
            || empty($value)
        ) {
            return false;
        }

        if (is_array($value)) {
            return end($value) === $end;
        }

        /** @var callable $strFunc */
        $strFunc = function_exists('mb_strcut') ? 'mb_strcut' : 'substr';

        return $strFunc($value, -1, 1) === $end;
    };
}

/**
 * @param $end
 * @return \Closure
 */
function notEndWith($end)
{
    return negate(endWith($end));
}

/**
 * @param array $values
 * @return \Closure
 */
function anyOfValues(array $values)
{
    return function ($value) use ($values) {
        return in_array($value, $values, true);
    };
}

/**
 * @param array $values
 * @return \Closure
 */
function notAnyOfValues(array $values)
{
    return function ($value) use ($values) {
        return ! in_array($value, $values, true);
    };
}

/**
 * @return \Closure
 */
function anyOf()
{
    return anyOfValues(func_get_args());
}

/**
 * @return \Closure
 */
function notAnyOf()
{
    return notAnyOfValues(func_get_args());
}
