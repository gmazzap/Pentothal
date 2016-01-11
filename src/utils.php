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
    try {
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
    } catch (\Exception $e) {
        return null;
    }
}

/**
 * @param callable $callable
 * @param array    $args
 * @return mixed
 */
function variadicCallBoolVal(callable $callable, array $args = [])
{
    return boolval(variadicCall($callable, $args));
}

/**
 * @param $value
 * @return int|void Void is returned for unknown types: should never happen
 */
function polymorphicSize($value)
{
    $size = null;
    $type = gettype($value);
    switch ($type) {
        case 'boolean' :
        case 'double' :
        case 'integer' :
        case 'resource' :
            $size = (int)$value;
            break;
        case 'array' :
            $size = count($value);
            break;
        case 'string' :
            $size = function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);
            break;
        case 'NULL' :
            $size = 0;
            break;
        case 'object' :
            $size = $value instanceof \Countable ? count($value) : 1;
            break;
    }

    return $size;
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
function callOnClone($object, $method, array $args = [])
{
    $clone = clone $object;
    $callback = [$clone, $method];

    return variadicCall($callback, $args);
}

/**
 * @param array|object $map
 * @return array
 */
function mapAsArray($map)
{
    if (is_array($map)) {
        return $map;
    } elseif ( ! is_object($map)) {
        throw new \InvalidArgumentException('A map must be an array or an object.');
    } elseif ($map instanceof \Iterator) {
        return iterator_to_array($map);
    } elseif ($map instanceof \Traversable) {
        $array = [];
        foreach ($map as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }

    return extractObjectVars($map);
}

/**
 * @param object $object
 * @return array
 */
function extractObjectVars($object) {
    if (is_null($object)) {
        return [];
    } elseif (! is_object($object)) {
        throw new \InvalidArgumentException('Invalid object.');
    }

    $getter = \Closure::bind(function() {
        return get_object_vars($this);
    }, $object, get_class($object));

    return $getter();
}