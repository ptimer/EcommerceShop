<?php

if (!function_exists("__autoload")) {
    function __autoload($className)
    {
        $className = '..\\..\\..\\' . $className;
        require_once str_replace("\\", "/", $className) . '.php';
    }
}