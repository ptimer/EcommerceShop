<?php

require_once '../../utility/error_handler.php';

//Автолоадинг классов
if (!function_exists("__autoload")) {
    function __autoload($className)
    {
        $className = '..\\..\\' . $className;
        require_once str_replace("\\", "/", $className) . '.php';
    }
}

try {
    $supercatDao = \model\database\SuperCategoriesDao::getInstance();
    $catDao = \model\database\CategoriesDao::getInstance();
    $subcatDao = \model\database\SubCategoriesDao::getInstance();

    $supercategories = $supercatDao->getAllSuperCategories();
    $categories = $catDao->getAllCategories();
    $subcategories = $subcatDao->getAllSubCategories();
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
    error_log($message, 3, '../../errors.log');
    header("Location: ../../view/error/error_500.php");
    die();
}