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
 * @param array    $args
 * @return mixed
 */
function variadicCall(callable $callable, array $args = [])
{
    switch (count($args)) {
        case 0:
            return $callable();
        case 1:
            return $callable($args[0]);
        case 2:
            return $callable($args[0], $args[1]);
        case 3:
            return $callable($args[0], $args[1], $args[2]);
        case 4:
            return $callable($args[0], $args[1], $args[2], $args[3]);
    }

    return call_user_func_array($callable, $args);
}

/**
 * @param callable $callable
 * @param array    $args
 * @return mixed
 */
function variadicCallNotEmpty(callable $callable, array $args = [])
{
    $result = variadicCall($callable, $args);

    return ! empty($result);
}

/**
 * @param $value
 * @return int
 */
function polymorphicSize($value)
{
    switch (gettype($value)) {
        case 'boolean' :
        case 'double' :
        case 'integer' :
        case 'resource' :
            return (int)$value;
        case 'array' :
            return count($value);
        case 'string' :
            return function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);
        case 'NULL' :
            return 0;
        case 'object' :
            return $value instanceof \Countable ? count($value) : 1;
    }

    return -1;
}

/**
 * @param $item
 * @param $key
 * @return mixed|null
 */
function polymorphicKeyValue($item, $key)
{
    return is_array($item) || $item instanceof \ArrayAccess
        ? $item[$key]
        : $item->{$key};
}

/**
 * @param object $object
 * @param string $method
 * @param array  $args
 * @return mixed
 */
function applyOnClone($object, $method, array $args = [])
{
    $clone = clone $object;
    $callback = [$clone, $method];

    return variadicCall($callback, $args);
}