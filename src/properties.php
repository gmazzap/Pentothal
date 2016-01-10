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
 * @param string $key
 * @return \Closure
 */
function hasKey($key)
{
    if ( ! is_string($key) || is_int($key)) {
        return never();
    }

    return function ($value) use ($key) {
        if ( ! is_array($value) && ! is_object($value)) {
            return false;
        }
        if (is_object($value) && ! $value instanceof \ArrayAccess) {
            return (bool)property_exists($value, $key);
        }

        return array_key_exists($key, $value);
    };
}

/**
 * @param string $key
 * @return \Closure
 */
function hasNotKey($key)
{
    return negate(hasKey($key));
}

/**
 * @return \Closure
 */
function hasKeys()
{
    $keys = array_filter(func_get_args(), 'is_string');
    if (empty($keys)) {
        return never();
    }

    return combineFactory($keys, '\\Pentothal\\hasKey');
}

/**
 * @return \Closure
 */
function hasNotKeys()
{
    $keys = array_filter(func_get_args(), 'is_string');
    if (empty($keys)) {
        return never();
    }

    return combineFactory($keys, '\\Pentothal\\hasNotKey');
}


/**
 * @return \Closure
 */
function hasAnyOfKeys()
{
    $keys = array_filter(func_get_args(), 'is_string');
    if (empty($keys)) {
        return never();
    }

    return poolFactory($keys, '\\Pentothal\\hasKey');
}

/**
 * @return \Closure
 */
function hasNotAnyOfKeys()
{
    $keys = array_filter(func_get_args(), 'is_string');
    if (empty($keys)) {
        return never();
    }

    return poolFactory($keys, '\\Pentothal\\hasNotKey');
}

/**
 * @param string $key
 * @param mixed  $value
 * @return \Closure
 */
function keyIs($key, $value)
{
    if ( ! is_string($key)) {
        return never();
    }

    return combine(
        hasKey($key),
        function ($item) use ($key, $value) {

            return polymorphicKeyValue($item, $key) === $item;
        }
    );
}

/**
 * @param string $key
 * @param mixed  $value
 * @return \Closure
 */
function keyIsNot($key, $value)
{
    return negate(keyIs($key, $value));
}

/**
 * @param string $key
 * @param array  $values
 * @return \Closure
 */
function keyIsAnyOf($key, array $values)
{
    if (empty($values)) {
        return never();
    }

    return combine(
        hasKey($key),
        function ($item) use ($key, $values) {

            return in_array(polymorphicKeyValue($item, $key), $values, true);
        }
    );
}

/**
 * @param string $key
 * @param array  $values
 * @return \Closure
 */
function keyIsNotAnyOf($key, array $values)
{
    return negate(keyIsAnyOf($key, $values));
}

/**
 * @param string $key
 * @param string $type
 * @return \Closure
 */
function keyIsType($key, $type)
{
    if ( ! is_string($key)) {
        return never();
    }

    return combine(
        hasKey($key),
        function ($item) use ($key, $type) {
            /** @var callable $typeCheck */
            $typeCheck = isType($type);

            return $typeCheck(polymorphicKeyValue($item, $key));
        }
    );
}

/**
 * @param string $key
 * @param string $type
 * @return \Closure
 */
function keyIsNotType($key, $type)
{
    return negate(keyIsType($key, $type));
}

/**
 * @param string   $key
 * @param callable $callback
 * @return \Closure
 */
function keyApply($key, callable $callback)
{
    if ( ! is_string($key)) {
        return never();
    }

    return combine(
        hasKey($key),
        function ($item) use ($key, $callback) {
            $args = func_get_args();
            $args[0] = polymorphicKeyValue($item, $key);

            return variadicCallBoolVal($callback, $args);
        }
    );
}

/**
 * @param string   $key
 * @param callable $callback
 * @return \Closure
 */
function notKeyApply($key, callable $callback)
{
    return negate(keyApply($key, $callback));
}

/**
 * @param mixed $value
 * @return \Closure
 */
function hasValue($value)
{
    return function ($item) use ($value) {
        if ( ! is_array($item) && ! is_object($item)) {
            return false;
        }
        /** @var object|array $item */
        if (is_object($item)) {
            $item = clone $item;
            $item instanceof \Traversable or $item = get_object_vars($item);
        }

        foreach ($item as $element) {
            if ($element === $value) {
                return true;
            }
        }


        return false;
    };
}

/**
 * @param mixed $value
 * @return \Closure
 */
function hasNotValue($value)
{
    return negate(hasValue($value));
}

/**
 * @return \Closure
 */
function hasValues()
{
    $values = func_get_args();
    if (empty($values)) {
        return never();
    }

    return combineFactory($values, '\\Pentothal\\hasValue');
}

/**
 * @return \Closure
 */
function hasNotValues()
{
    $values = func_get_args();
    if (empty($values)) {
        return never();
    }

    return combineFactory($values, '\\Pentothal\\hasNotValue');
}

/**
 * @return \Closure
 */
function hasAnyOfValues()
{
    $values = func_get_args();
    if (empty($values)) {
        return never();
    }

    return poolFactory($values, '\\Pentothal\\hasValue');
}

/**
 * @return \Closure
 */
function hasNotAnyOfValues()
{
    $values = func_get_args();
    if (empty($values)) {
        return never();
    }

    return poolFactory($values, '\\Pentothal\\hasNotValue');
}
