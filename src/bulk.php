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
 * @param callable $callable
 * @return \Closure
 */
function bulk(callable $callable)
{
    return function ($value) use ($callable) {
        if ( ! is_array($value) && ! $value instanceof \Traversable) {
            return false;
        }
        $args = func_get_args();
        foreach ($value as $item) {
            $args[0] = $item;
            if ( ! variadicCallBoolVal($callable, $args)) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param callable $callable
 * @return \Closure
 */
function bulkPool(callable $callable)
{
    return function ($value) use ($callable) {
        if ( ! is_array($value) && ! $value instanceof \Traversable) {
            return false;
        }
        $args = func_get_args();
        foreach ($value as $item) {
            $args[0] = $item;
            if (variadicCallBoolVal($callable, $args)) {
                return true;
            }
        }

        return false;
    };
}