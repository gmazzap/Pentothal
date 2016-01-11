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
    if (! is_string($key) || is_int($key)) {
        return never();
    }

    return function ($value) use ($key) {
        if (! is_array($value) && ! is_object($value)) {
            return false;
        }
        if (is_object($value) && ! $value instanceof \ArrayAccess) {
            return (bool) property_exists($value, $key);
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
 * @param string[] $keys
 * @return \Closure
 */
function hasKeys(array $keys)
{
    $keys = array_filter($keys, 'is_string');
    if (empty($keys)) {
        return never();
    }

    return combineFactory($keys, '\\Pentothal\\hasKey');
}

/**
 * @param string[] $keys
 * @return \Closure
 */
function hasNotKeys(array $keys)
{
    return negate(hasKeys($keys));
}

/**
 * @param string[] $keys
 * @return \Closure
 */
function hasAnyOfKeys(array $keys)
{
    $keys = array_filter($keys, 'is_string');
    if (empty($keys)) {
        return never();
    }

    return poolFactory($keys, '\\Pentothal\\hasKey');
}

/**
 * @param string[] $keys
 * @return \Closure
 */
function hasNotAnyOfKeys(array $keys)
{
    return negate(hasAnyOfKeys($keys));
}

/**
 * @param string $key
 * @param mixed  $value
 * @return \Closure
 */
function keyIs($key, $value)
{
    if (! is_string($key)) {
        return never();
    }

    return combine(
        hasKey($key),
        function ($item) use ($key, $value) {

            return polymorphicKeyValue($item, $key) === $value;
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
    if (! is_string($key)) {
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
    if (! is_string($key)) {
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
 * @param mixed $value
 * @return \Closure
 */
function hasValue($value)
{
    return function ($item) use ($value) {
        if (! is_array($item) && ! is_object($item)) {
            return false;
        }
        /** @var object|array $item */
        if (is_object($item)) {
            $clone = clone $item;
            unset($item);
<<<<<<< HEAD
            ($clone instanceof \Traversable) or $clone = get_object_vars($clone);
=======
            ($clone instanceof \Traversable) or $clone = extractObjectVars($clone);
>>>>>>> refs/remotes/origin/dev
            $item = $clone;
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
 * @param array $values
 * @return \Closure
 */
function hasValues(array $values)
{
    if (empty($values)) {
        return never();
    }

    return combineFactory($values, '\\Pentothal\\hasValue');
}

/**
 * @param array $values
 * @return \Closure
 */
function hasNotValues(array $values)
{
    return negate(hasValues($values));
}

/**
 * @param array $values
 * @return \Closure
 */
function hasAnyOfValues(array $values)
{
    if (empty($values)) {
        return never();
    }

    return poolFactory($values, '\\Pentothal\\hasValue');
}

/**
 * @param array $values
 * @return \Closure
 */
function hasNotAnyOfValues(array $values)
{
    return negate(hasAnyOfValues($values));
}
