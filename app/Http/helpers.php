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
 * Show old checkbox value on edit and create.
 *
 * @param  string $name The checkbox name
 * @param  string $value The checkbox value
 */
function c($name) {
    if (!empty(old($name))) {
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

function form_label() {
    if(Request::segment(3) == "edit") {
        return ' - Update';
    } else {
        return ' - Add New Record';
    }
}

function form_action() {
    return '/' . Request::path();
}
