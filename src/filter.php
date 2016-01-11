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
 * @param int       $filter
 * @param array|int $options
 * @return \Closure
 */
function filterVar($filter, $options = null)
{
    return function ($value) use ($filter, $options) {
        return (bool) filter_var($value, $filter, $options);
    };
}

/**
 * @return \Closure
 */
function isEmail()
{
    return filterVar(FILTER_VALIDATE_EMAIL);
}

/**
 * @return \Closure
 */
function isNotEmail()
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

        return (bool) filter_var($value, FILTER_VALIDATE_URL);
    };
}

/**
 * @return \Closure
 */
function isNotUrl()
{
    return negate(isUrl());
}

/**
 * @return \Closure
 */
function isIp()
{
    return filterVar(FILTER_VALIDATE_IP);
}

/**
 * @return \Closure
 */
function isNotIp()
{
    return negate(isIp());
}

/**
 * @return \Closure
 */
function isMac()
{
    return filterVar(FILTER_VALIDATE_MAC);
}

/**
 * @return \Closure
 */
function isNotMac()
{
    return negate(isMac());
}
