<?php

/**
 * Display old form value on edit and create.
 *
 * @param  string $key
 */
function v($key) {
    return old($key);
}

/**
 * Show old radio button value on edit and create.
 *
 * @param  string $name The radio name
 * @param  string $value The radio value
 */
function r($name, $value) {
    if (old($name) == $value) {
        return ' checked="checked" ';
    }
}

/**
 * Show old select box value on edit and create.
 *
 * @param  string $name The select box name
 * @param  string $value The select box value
 */
function s($name, $value) {
    if (old($name) == $value) {
        return ' selected ';
    }
}

