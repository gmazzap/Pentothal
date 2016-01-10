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
 * @param string $type
 * @return \Closure
 */
function isType($type)
{
    if (is_object($type)) {
        $type = get_class($type);
    }

    if (! is_string($type)) {
        return never();
    }

    if (class_exists($type) || interface_exists($type)) {
        return function ($value) use ($type) {
            return is_object($value) && is_a($value, $type, false);
        };
    }

    return function ($value) use ($type) {
        $nType = strtolower($type);
        $nType === 'float' and $nType = 'double';
        $nType === 'bool' and $nType = 'boolean';
        $nType === 'int' and $nType = 'integer';
        $nType === 'null' and $nType = 'NULL';

        return gettype($value) === $nType;
    };
}

/**
 * @param string $type
 * @return \Closure
 */
function isNotType($type)
{
    return negate(isType($type));
}

/**
 * @return callable
 */
function isInt()
{
    return '\is_int';
}

/**
 * @return \Closure
 */
function isNotInt()
{
    return negate(isInt());
}

/**
 * @return callable
 */
function isFloat()
{
    return '\is_float';
}

/**
 * @return \Closure
 */
function isNotFloat()
{
    return negate(isFloat());
}

/**
 * @return callable
 */
function isNumber()
{
    return '\is_numeric';
}

/**
 * @return \Closure
 */
function isNotNumber()
{
    return negate(isNumber());
}

/**
 * @return callable
 */
function isBool()
{
    return '\is_bool';
}

/**
 * @return \Closure
 */
function isNotBool()
{
    return negate(isBool());
}

/**
 * @return callable
 */
function isNull()
{
    return '\is_null';
}

/**
 * @return \Closure
 */
function isNotNull()
{
    return negate(isNull());
}

/**
 * @return callable
 */
function isString()
{
    return '\is_string';
}

/**
 * @return \Closure
 */
function isNotString()
{
    return negate(isString());
}

/**
 * @return callable
 */
function isObject()
{
    return '\is_object';
}

/**
 * @return \Closure
 */
function isNotObject()
{
    return negate(isObject());
}

/**
 * @return callable
 */
function isArray()
{
    return '\is_array';
}

/**
 * @return \Closure
 */
function isNotArray()
{
    return negate(isArray());
}
