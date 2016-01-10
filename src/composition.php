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
 * @param array $callbacks
 * @return \Closure
 */
function combineCallbacks(array $callbacks)
{
    $callbacks = array_filter($callbacks, 'is_callable');
    if (empty($callbacks)) {
        return never();
    }

    return function ($value) use ($callbacks) {
        /** @var callable $cb */
        foreach ($callbacks as $cb) {
            if (! variadicCallBoolVal($cb, func_get_args())) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @return \Closure
 */
function combine()
{
    return combineCallbacks(func_get_args());
}

/**
 * @param array    $args
 * @param callable $callable
 * @return \Closure
 */
function combineFactory(array $args, callable $callable)
{
    return combineCallbacks(array_map(function ($item) use ($callable) {
        return $callable($item);
    }, $args));
}

/**
 * @param callable[] $callbacks
 * @return \Closure
 */
function poolCallbacks(array $callbacks)
{
    $callbacks = array_filter($callbacks, 'is_callable');
    if (empty($callbacks)) {
        return never();
    }

    return function ($value) use ($callbacks) {
        /** @var callable $cb */
        foreach ($callbacks as $cb) {
            if (variadicCallBoolVal($cb, func_get_args())) {
                return true;
            }
        }

        return false;
    };
}

/**
 * @return \Closure
 */
function pool()
{
    return poolCallbacks(func_get_args());
}

/**
 * @param callable[] $args
 * @param callable   $callable
 * @return \Closure
 */
function poolFactory(array $args, callable $callable)
{
    return poolCallbacks(array_map(function ($item) use ($callable) {
        return $callable($item);
    }, $args));
}
