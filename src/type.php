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

    if ( ! is_string($type)) {
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
function notIsType($type)
{
    return negate(isType($type));
}

/**
 * @param string $regex
 * @return \Closure
 */
function match($regex)
{
    if ( ! is_string($regex) || $regex === '') {
        return never();
    }

    $first = substr($regex, 0, 1);
    $last = substr($regex, -1, 1);
    if (($first !== $last) || strlen($regex) === 1) {
        $regex = "/{$regex}/";
    }

    return function ($value) use ($regex) {
        return is_string($value) && @preg_match($regex, $value) === 1;
    };
}

/**
 * @param string $regex
 * @return \Closure
 */
function notMatch($regex)
{
    return negate(match($regex));
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
function notIsInt()
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
function notIsFloat()
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
function notIsNumber()
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
function notIsBool()
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
function notIsNull()
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
function notIsString()
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
function notIsObject()
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
function notIsArray()
{
    return negate(isArray());
}

/**
 * @return \Closure
 */
function isEmail()
{
    return function ($value) {
        return (bool)filter_var($value, FILTER_VALIDATE_EMAIL);
    };
}

/**
 * @return \Closure
 */
function notIsEmail()
{
    return negate(isEmail());
}

/**
 * @return \Closure
 */
function isUrl()
{
    return function ($value) {
        // FILTER_VALIDATE_URL does not recognize protocol-relative urls
        if (is_string($value) && strpos($value, '//') === 0) {
            $value = 'http:'.$value;
        }

        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    };
}

/**
 * @return \Closure
 */
function notIsUrl()
{
    return negate(isUrl());
}

/**
 * @return \Closure
 */
function isIp()
{
    return function ($value) {
        return (bool)filter_var($value, FILTER_VALIDATE_IP);
    };
}

/**
 * @return \Closure
 */
function notIsIp()
{
    return negate(isIp());
}

/**
 * @return \Closure
 */
function isMac()
{
    return function ($value) {
        return (bool)filter_var($value, FILTER_VALIDATE_MAC);
    };
}

/**
 * @return \Closure
 */
function notIsMac()
{
    return negate(isMac());
}
