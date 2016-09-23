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

function url_with_query($url)
{
    $url = url($url);
    return $url . '?' . app('request')->getQueryString();
}

function query_string()
{
    $query = app('request')->getQueryString();
    return empty($query) ? '' : '?' . $query;
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
    if (is_null($number)) {
        return '-';
    }

    $number = strrev($number);
    $number = preg_replace("/^(\d{4})(\d{3})(\d+)$/", "$1-$2-$3", $number);
    return strrev($number);
}

function phone_number_spaces($number)
{
    if (is_null($number)) {
        return '-';
    }

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

function style_datetime($date)
{
    $date = strtotime($date);
    if (empty($date)) {
        return '-';
    }
    return date("M jS, Y H:i:s", $date);
}

function mobile_date($date)
{
    $date = strtotime($date);
    if (empty($date)) {
        return '-';
    }
    return date("M jS, Y", $date) . '<br/>' . date("H:i:s", $date);
}

function absent_date($date)
{
    $date = strtotime($date);
    if (empty($date)) {
        return '-';
    }
    return date("l, F d, Y", $date);
}

function hour_minutes($date)
{
    return date('h:i', strtotime($date));
}

function current_date()
{
    return date('M jS, Y');
}

function current_time()
{
    return date('h:i A');
}

function current_datetime()
{
    return date('M jS, Y H:i');
}

function current_system_date()
{
    return date('Y-m-d');
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

function marks($marks)
{
    if (is_numeric($marks)) {
        return intval($marks);
    }
    return '';
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

function queryStringValue($key)
{
    $input = app('request')->input($key);
    return !is_null($input) ? $input : '';
}

function activeSelectByTwo($firstValue, $secondValue, $firstKey, $secondKey)
{
    $firstKey = app('request')->input($firstKey);
    $secondKey = app('request')->input($secondKey);

    if (is_null($firstKey) || is_null($secondKey)) {
        return '';
    }

    if ($firstKey == $firstValue && $secondKey == $secondValue) {
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

function holiday($value)
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

/**
 * Get the fourth resultset from the stored procedure results.
 * @param  array $data Stored procedure return.
 * @return array
 */
function fourth_resultset($data)
{
    if (isset($data[3])) {
        return $data[3];
    }

    return [];
}

function domain()
{
    return session()->get('user.domain_name');
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

function userIp()
{
    return app('request')->ip();
}

function selected_dropdown($name, $options, $keyId, $keyName)
{
    foreach($options as $option) {
        if (old($name) == $option[$keyId]) {
            return $option[$keyName];
        }
    }
    return '-';
}

function redirect_back()
{
    return app('redirect')->back();
}

function menu_link($name) {
    $name = strtolower($name);
    return str_replace(' ', '-', $name);
}

function screen_id_from_hidden_menu_info($screenId)
{
    if (is_null($screenId)) {
        return null;

    } else {
        $hiddenMenuInfo = session()->get('dbHiddenMenuInfo');
        foreach ((array) $hiddenMenuInfo as $link) {
            if (!isset($link['screen_name']) || !isset($link['screen_id'])) {
                continue;
            }
            $url = '/' . menu_link($link['screen_name']);
            if ($screenId == $url) {
                return $link['screen_id'];
            }
        }
    }

    return null;
}

function screen_id($screenId)
{
    if (is_null($screenId)) {
        return null;

    } else {
        $urls = session()->get('siteUrls');
        $hiddenUrls = session()->get('hiddenSiteUrls');
        foreach ((array) $urls as $url) {
            if (isset($url['url']) && isset($url['screen_id']) && $screenId == $url['url']) {
                return $url['screen_id'];
            }
        }
        foreach ((array) $hiddenUrls as $url) {
            if (isset($url['url']) && isset($url['screen_id']) && $screenId == $url['url']) {
                return $url['screen_id'];
            }
        }
    }

    return null;
}

function screen_name($screenId)
{
    if (is_null($screenId)) {
        return '';

    } else {
        $urls = session()->get('siteUrls');
        $hiddenUrls = session()->get('hiddenSiteUrls');
        foreach ((array) $urls as $url) {
            if (isset($url['url']) && isset($url['screen_name']) && $screenId == $url['url']) {
                return $url['screen_name'];
            }
        }
        foreach ((array) $hiddenUrls as $url) {
            if (isset($url['url']) && isset($url['screen_name']) && $screenId == $url['url']) {
                return $url['screen_name'];
            }
        }
    }

    return '';
}

function student_picture($id)
{
    $imgPath = storage_path('uploads/'. domain() . "/student-images/{id}");

    if (file_exists($imgPath)) {
        return "/cabinet/img/student/{$id}?w=100&h=100&ri=".time().uniqid();
    }

    return '/dashboard/student.jpg';
}

function student_picture_path($id)
{
    $imgPath = public_path('dashboard/student.png');

    $extensionPath = storage_path('uploads/'.domain()."/student-images/{$id}");

    if (file_exists($extensionPath)) {
        $extension = file_get_contents($extensionPath);
        $extension = trim($extension);
        if (file_exists($extensionPath.'.'.$extension)) {
            $imgPath = $extensionPath.'.'.$extension;
        }
    }

    return $imgPath;
}

function pdf_label()
{
    if (Device::isAndroidMobile()) {
        return 'Report';
    }

    return 'PDF';
}

function logo_path()
{
    $logo = storage_path('uploads/'.domain().'/school-logo/logo.png');
    if (!file_exists($logo)) {
        $logo = public_path('images/school-logo.png');
    }
    return $logo;
}

function force_change_password()
{
    return session()->get('user.forceChangePassword');
}

function force_login_otp()
{
    return session()->get('user.forceLoginOTPCode');
}
