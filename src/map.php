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
 * @param callable[] $callbacks
 * @return \Closure
 */
function combineMap(array $callbacks)
{
    $callbacks = array_filter($callbacks, 'is_callable');
    if (empty($callbacks)) {
        return never();
    }

    return function ($item) use ($callbacks) {
        if (! is_array($item) && ! is_object($item)) {
            return false;
        }

        foreach ($callbacks as $key => $callback) {
            if (! variadicCallBoolVal(keyApply($key, $callback), func_get_args())) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param callable[] $callbacks
 * @return \Closure
 */
function poolMap(array $callbacks)
{
    $callbacks = array_filter($callbacks, 'is_callable');
    if (empty($callbacks)) {
        return never();
    }

    return function ($item) use ($callbacks) {
        if (! is_array($item) && ! is_object($item)) {
            return false;
        }

        foreach ($callbacks as $key => $callback) {
            if (variadicCallBoolVal(keyApply($key, $callback), func_get_args())) {
                return true;
            }
        }

        return false;
    };
}
