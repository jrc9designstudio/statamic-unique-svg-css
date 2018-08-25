<?php

namespace Statamic\Addons\UniqueSvgCss;

use Statamic\Extend\Modifier;

class UniqueSvgCssModifier extends Modifier
{
    /**
     * Modify a value
     *
     * @param mixed  $value    The value to be modified
     * @param array  $params   Any parameters used in the modifier
     * @param array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        // Make a unique string by hashing the content
        $uniq = md5($value);

        // append - and unique data attribute after every class attribute
        $result = preg_replace('/(class="[\\w\\s-_:]+")/uism', '$1 data-' . $uniq . ' ', $value);

        // find any inline css classes and add - and uniq data attributes to the selector
        // this needs to work with spaces, without spaces on comma seperated lists of classes
        // this also needs to not find attributes that look similar in the svg
        $result = preg_replace('/(?<=[.])([\\w-_]+)([,{\\s])(?=[a-z.{\\s]{2})/uis', '$1[data-' . $uniq . ']$2', $result);

        return $result;
    }
}
