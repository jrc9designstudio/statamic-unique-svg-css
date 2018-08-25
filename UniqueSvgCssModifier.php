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

        // find any inline css classes and add - and uniq data attributes to the selector
        // this needs to work with spaces, without spaces on comma seperated lists of classes
        // this also needs to not find attributes that look similar in the svg
        preg_match('/(?<=<style>)(.+)(?=<\/style>)/usm', $value, $result);
        if (sizeof($result) > 0) {
            $replace = preg_replace('/(?<=[.]{1})([\\w-_:]+)(?=[{,\\s\\.]{1})/u', '$1[data-' . $uniq . ']', $result[0]);
            $value = preg_replace('/(?<=<style>)(.+)(?=<\/style>)/usm', $replace, $value);
        } else {
            preg_match('/(?<=<style\stype="text\/css">)(.+)(?=<\/style>)/usm', $value, $result);
            if (sizeof($result) > 0) {
                $replace = preg_replace('/(?<=[.]{1})([\\w-_:]+)(?=[{,\\s\\.]{1})/u', '$1[data-' . $uniq . ']', $result[0]);
                $value = preg_replace('/(?<=<style\stype="text\/css">)(.+)(?=<\/style>)/usm', $replace, $value);
            }
        }

        // append - and unique data attribute after every class attribute
        $value = preg_replace('/(class="[\\w\\s-_:]+")/u', '$1 data-' . $uniq . ' ', $value);

        return $value;
    }
}
