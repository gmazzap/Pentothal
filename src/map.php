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
 * Applies a predicates map to a subject map.
 *
 * Takes a map of predicates and a subject in form of map, then apply to any item in the subject
 * map
 * the predicate that has the same key in the predicate map.
 * The resulting array is composed by all the key of subject set to `true` if the related predicate
 * returned `true` and `false` if  if the related predicate returned `false`.
 * All subject items without related predicate are `true` in the result.
 * Any item that is not callable in the predicate map is ignored.
 *
 * @param array|object $predicateMap
 * @param array|object $subjectMap
 * @return bool[]
 * @throws \InvalidArgumentException If either `$predicateMap` or `$subjectMap` aren't objects or
 *                                   arrays
 *  *
 *  Example:
 *
 * <code>
 * <?php
 * use Pentothal as P;
 *
 * $predicates = [
 *   'name'  => combine(P\isString(), P\isNotEmpty()),
 *   'email' => P\isEmail(),
 *   'phone' => combine(P\isString(), P\startWith('+'), P\sizeMin(5)),
 * ];
 *
 * $user = [
 *   'name'  => 'John Doe',
 *   'email' => 'john.doe@johndoe.me',
 *   'phone' => '---',
 * ];
 *
 * $correct = map($predicates, $user);
 *
 * var_export($errors); // array('name' => true, 'email' => true, 'phone' => false)
 * ?>
 * </code>
 */
function map($predicateMap, $subjectMap)
{
    /** @var array $predicates */
    $predicates = array_filter(mapAsArray($predicateMap), 'is_callable');
    /** @var array $subject */
    $subject = mapAsArray($subjectMap);

    $result = array_fill_keys(array_keys($subject), true);
    array_walk($predicates, function (callable $predicate, $key, $subject) use (&$result) {
        isset($subject[$key]) and $result[$key] = $predicate($subject[$key]);
    }, $subject);

    return $result;
}

/**
 * Apply an inverse predicates map to a subject map.
 *
 * Takes a map of predicates and a subject in form of map, then apply to any item in the subject
 * map
 * the inverse of the predicate that has the same key in the predicate map.
 * The resulting array is composed by all the key of subject set to `true` if the related predicate
 * returned `false` and `false` if  if the related predicate returned `true`.
 * All subject items without related predicate are `false` in the result.
 * Any item that is not callable in the predicate map is ignored.
 *
 * Example:
 *
 * <code>
 * <?php
 * use Pentothal as P;
 *
 * $predicates = [
 *   'name'  => combine(P\isString(), P\isNotEmpty()),
 *   'email' => P\isEmail(),
 *   'phone' => combine(P\isString(), P\startWith('+'), P\sizeMin(5)),
 * ];
 *
 * $user = [
 *   'name'  => 'John Doe',
 *   'email' => 'john.doe@johndoe.me',
 *   'phone' => '---',
 * ];
 *
 * $errors = mapInverse($predicates, $user);
 *
 * var_export($errors); // array('name' => false, 'email' => false, 'phone' => true)
 * ?>
 * </code>
 *
 * @param array|object $predicateMap
 * @param array|object $subjectMap
 * @return bool[]
 * @throws \InvalidArgumentException If either `$predicateMap` or `$subjectMap` aren't objects or
 *                                   arrays
 */
function mapInverse($predicateMap, $subjectMap)
{
    /** @var array $predicates */
    $predicates = array_filter(mapAsArray($predicateMap), 'is_callable');
    /** @var array $subject */
    $subject = mapAsArray($subjectMap);

    $result = array_fill_keys(array_keys($subject), false);
    array_walk($predicates, function (callable $predicate, $key, $subject) use (&$result) {
        $negate = negate($predicate);
        isset($subject[$key]) and $result[$key] = $negate($subject[$key]);
    }, $subject);

    return $result;
}
