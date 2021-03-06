<?php

require_once '../../../utility/error_handler_dir_back.php';


require_once '../../../utility/admin_session.php';


//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

try {
    $catDao = \model\database\CategoriesDao::getInstance();
    $cats = $catDao->getAllCategoriesAdmin();
} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
    error_log($message, 3, '../../../errors.log');
    header("Location: ../../../view/error/error_500.php");
    die();
}