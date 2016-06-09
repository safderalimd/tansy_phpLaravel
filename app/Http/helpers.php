<?php

use Illuminate\Support\Debug\Dumper;

/**
 * Display old form value on edit and create.
 *
 * @param  string $key
 */
function v($key)
{
    return old($key);
}

/**
 * Show old radio button value on edit and create.
 *
 * @param  string $name The radio name
 * @param  string $value The radio value
 */
function r($name, $value)
{
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
function c($name)
{
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
function s($name, $value)
{
    if (old($name) == $value) {
        return ' selected ';
    }
}

function form_label()
{
    if(app('request')->segment(3) == "edit") {
        return ' - Update';
    } else {
        return ' - Add New Record';
    }
}

function form_action()
{
    return '/' . app('request')->path();
}

function form_action_full()
{
    return app('request')->fullUrl();
}

function is_locked($value)
{
    $value = strtolower($value);
    $value = str_replace(['', '-'], '', $value);

    if ($value == 'yes' || $value == 'locked') {
        return true;
    }

    return false;
}

function phone_number($number)
{
    $number = strrev($number);
    $number = preg_replace("/^(\d{4})(\d{3})(\d+)$/", "$1-$2-$3", $number);
    return strrev($number);
}

function phone_number_spaces($number)
{
    $number = strrev($number);
    $number = preg_replace("/^(\d{4})(\d{3})(\d+)$/", "$1 $2 $3", $number);
    return strrev($number);
}

/**
 * Format dates like this 'May 26th, 2015'
 *
 * @param  string $date Date in the format '2015-03-21'
 * @return string
 */
function style_date($date)
{
    $date = strtotime($date);

    if (empty($date)) {
        return '-';
    }

    return date("M jS, Y", $date);
}

function current_date()
{
    return date('M jS, Y');
}

function current_time()
{
    return date('H:i A');
}

function amount($amount)
{
    return number_format(floatval($amount), 2);
}

function sms($amount)
{
    return number_format(floatval($amount), 0);
}

function nr($number)
{
    return number_format(floatval($number), 0);
}

/**
 * Dump function
 */
function d()
{
    array_map(function ($x) {
        (new
         Dumper)->dump($x);
    }, func_get_args());
}

function activeLink($value, $getKey, $isDefault = false)
{
    $input = app('request')->input($getKey);

    if (empty($input) && $isDefault) {
        return 'active';
    }

    if ($input == $value) {
        return 'active';
    }

    return '';
}

function activeSelect($value, $getKey, $isDefault = false)
{
    $input = app('request')->input($getKey);

    if (empty($input) && $isDefault) {
        return 'selected';
    }

    if (!is_null($input) && ($input == $value)) {
        return 'selected';
    }

    return '';
}

function activeSelectAccount($option)
{
    $aei = app('request')->input('aei');
    $art = app('request')->input('art');

    if (is_null($aei) || is_null($art)) {
        return '';
    }

    if ($aei == $option['entity_id'] && $art == $option['row_type']) {
        return 'selected';
    }

    return '';
}

function activeExam($value, $getKey)
{
    $input = app('request')->input($getKey);

    if ($input == $value) {
        return 'active-exam';
    }

    return '';
}

function absent($value)
{
    if (!empty($value)) {
        return '1';
    }
    return '0';
}

/**
 * Get the first resultset from the stored procedure results.
 * @param  array $data Stored procedure return.
 * @return array
 */
function first_resultset($data)
{
    if (isset($data[0])) {
        return $data[0];
    }

    return [];
}

/**
 * Get the second resultset from the stored procedure results.
 * @param  array $data Stored procedure return.
 * @return array
 */
function second_resultset($data)
{
    if (isset($data[1])) {
        return $data[1];
    }

    return [];
}

/**
 * Get the third resultset from the stored procedure results.
 * @param  array $data Stored procedure return.
 * @return array
 */
function third_resultset($data)
{
    if (isset($data[2])) {
        return $data[2];
    }

    return [];
}

function domain()
{
    return session()->get('dbConnectionData.login_domain');
}

function currentMenuLink($item)
{
    $filtered = $item->children()->filter(function ($item) {
        if ($item->hasChildren()) {
            return currentMenuLink($item);
        }
        return $item->url() == app('request')->url();
    });

    if (count($filtered)) {
        return true;
    }

    return false;
}
