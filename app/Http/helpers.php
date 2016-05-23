<?php

use Illuminate\Support\Debug\Dumper;

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

function is_locked($value) {
    $value = strtolower($value);
    $value = str_replace(['', '-'], '', $value);

    if ($value == 'yes' || $value == 'locked') {
        return true;
    }

    return false;
}

function phone_number($number) {
    $number = strrev($number);
    $number = preg_replace("/^(\d{4})(\d{3})(\d+)$/", "$1-$2-$3", $number);
    return strrev($number);
}

function phone_number_spaces($number) {
    $number = strrev($number);
    $number = preg_replace("/^(\d{4})(\d{3})(\d+)$/", "$1 $2 $3", $number);
    return strrev($number);
}

function current_date() {
    return date('jS M, Y');
}

function current_time() {
    return date('H:i A');
}

function amount($amount) {
    return number_format($amount, 2);
}

/**
 * Dump function
 */
function d()
{
    array_map(function ($x) {
        (new Dumper)->dump($x);
    }, func_get_args());
}
