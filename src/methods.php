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
 * @param string $method
 * @return \Closure
 */
function hasMethod($method)
{
    if (! is_string($method)) {
        return never();
    }

    return combine(
        pool(isObject(), combine(isString(), 'class_exists')),
        function ($object) use ($method) {
            return method_exists($object, $method);
        }
    );
}

/**
 * @param string $method
 * @return \Closure
 */
function hasNotMethod($method)
{
    return negate(hasMethod($method));
}

/**
 * @param string $method
 * @param mixed  $value
 * @return \Closure
 */
function methodReturn($method, $value)
{
    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $value) {
            $args = array_slice(func_get_args(), 1);

            return $value === callOnClone($object, $method, $args);
        }
    );
}

/**
 * @param string $method
 * @param mixed  $value
 * @return \Closure
 */
function methodNotReturn($method, $value)
{
    return negate(methodReturn($method, $value));
}

/**
 * @param string $method
 * @param array  $values
 * @return \Closure
 */
function methodReturnAnyOf($method, array $values)
{
    if (empty($values)) {
        return never();
    }

    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $values) {
            $args = array_slice(func_get_args(), 1);

            return in_array(callOnClone($object, $method, $args), $values, true);
        }
    );
}

/**
 * @param string $method
 * @param array  $values
 * @return \Closure
 */
function methodNotReturnAnyOf($method, array $values)
{
    return negate(methodReturnAnyOf($method, $values));
}

/**
 * @param string        $method
 * @param string|object $type
 * @return \Closure
 */
function methodReturnType($method, $type)
{
    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $type) {
            $args = array_slice(func_get_args(), 1);
            /** @var \Closure $typeCheck */
            $typeCheck = isType($type);
            $return = callOnClone($object, $method, $args);

            return $typeCheck($return);
        }
    );
}

/**
 * @param string        $method
 * @param string|object $type
 * @return \Closure
 */
function methodNotReturnType($method, $type)
{
    return negate(methodReturnType($method, $type));
}

/**
 * @param string $method
 * @return \Closure
 */
function methodReturnEmpty($method)
{
    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method) {
            $args = array_slice(func_get_args(), 1);
            $return = callOnClone($object, $method, $args);

            return empty($return);
        }
    );
}

/**
 * @param string $method
 * @return \Closure
 */
function methodReturnNotEmpty($method)
{
    return negate(methodReturnEmpty($method));
}

/**
 * @param string   $method
 * @param callable $callback
 * @return \Closure
 */
function methodReturnApply($method, callable $callback)
{
    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $callback) {
            $args = array_slice(func_get_args(), 1);

            return $callback(callOnClone($object, $method, $args));
        }
    );
}
