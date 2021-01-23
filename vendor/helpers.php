<?php
use System\Application;

if (!function_exists('pre')) {
    function pre($var = NULL,$exit_status = 0)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        if ($exit_status == 1) exit();
    } 
} 

if (!function_exists('array_get')) {
    function array_get($array, $key, $default = null)
    {
        return isset($array[$key])?$array[$key]:$default;
    } 
} 

if (!function_exists('_e')) {
    function _e($value)
    {
        return htmlspecialchars($value);
    } 
}

if (!function_exists('assets')) {
    function assets($path)
    {
        $app = Application::getInstance();
        return $app->url->link('public/'.$path);
    } 
}

if (!function_exists('url')) {
    function url($path)
    {
        $app = Application::getInstance();
        return $app->url->link($path);
    } 
}