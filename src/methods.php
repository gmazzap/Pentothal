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
 * @param array  $methodArgs
 * @return \Closure
 */
function methodReturn($method, $value, array $methodArgs = [])
{
    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $value, $methodArgs) {
            return $value === callOnClone($object, $method, $methodArgs);
        }
    );
}

/**
 * @param string $method
 * @param mixed  $value
 * @param array  $methodArgs
 * @return \Closure
 */
function methodNotReturn($method, $value, array $methodArgs = [])
{
    return negate(methodReturn($method, $value, $methodArgs));
}

/**
 * @param string $method
 * @param array  $values
 * @param array  $methodArgs
 * @return \Closure
 */
function methodReturnAnyOf($method, array $values, array $methodArgs = [])
{
    if (empty($values)) {
        return never();
    }

    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $values, $methodArgs) {
            return in_array(callOnClone($object, $method, $methodArgs), $values, true);
        }
    );
}

/**
 * @param string $method
 * @param array  $values
 * @param array  $methodArgs
 * @return \Closure
 */
function methodNotReturnAnyOf($method, array $values, array $methodArgs = [])
{
    return negate(methodReturnAnyOf($method, $values, $methodArgs));
}

/**
 * @param string        $method
 * @param string|object $type
 * @param array         $methodArgs
 * @return \Closure
 */
function methodReturnType($method, $type, array $methodArgs = [])
{
    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $type, $methodArgs) {
            /** @var \Closure $typeCheck */
            $typeCheck = isType($type);
            $return = callOnClone($object, $method, $methodArgs);

            return $typeCheck($return);
        }
    );
}

/**
 * @param string        $method
 * @param string|object $type
 * @param array         $methodArgs
 * @return \Closure
 */
function methodNotReturnType($method, $type, array $methodArgs = [])
{
    return negate(methodReturnType($method, $type, $methodArgs));
}

/**
 * @param string $method
 * @param array  $methodArgs
 * @return \Closure
 */
function methodReturnEmpty($method, array $methodArgs = [])
{
    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $methodArgs) {
            $return = callOnClone($object, $method, $methodArgs);

            return empty($return);
        }
    );
}

/**
 * @param string $method
 * @param array  $methodArgs
 * @return \Closure
 */
function methodReturnNotEmpty($method, array $methodArgs = [])
{
    return negate(methodReturnEmpty($method, $methodArgs));
}

/**
 * @param string   $method
 * @param callable $callback
 * @param array    $methodArgs
 * @return \Closure
 */
function methodReturnApply($method, callable $callback, array $methodArgs = [])
{
    return combine(
        isObject(),
        hasMethod($method),
        function ($object) use ($method, $callback, $methodArgs) {
            return $callback(callOnClone($object, $method, $methodArgs));
        }
    );
}
