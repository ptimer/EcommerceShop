<?php

require_once '../../../utility/error_handler_dir_back.php';


require_once '../../../utility/admin_mod_session.php';

//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}


if (isset($_GET['pid'])) {
    $productId = $_GET['pid'];
    try {
        $productSpecsDao = \model\database\ProductSpecificationsDao::getInstance();
        $specs = $productSpecsDao->getAllSpecificationsForProductAdmin($productId);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header('HTTP/1.1 500 Internal Server Error', true, 500);
        die();
    }

    header('Content-Type: application/json');

    echo json_encode($specs);
} else {
    header('HTTP/1.1 400 Bad Request', true, 400);
    die();
}