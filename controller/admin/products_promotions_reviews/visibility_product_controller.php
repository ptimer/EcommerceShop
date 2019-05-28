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

    //Валидация
    if (!($_GET['vis'] == 1 || $_GET['vis'] == 0)) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        die();
    }

    try {
        $productId = $_GET['pid'];
        $currentVis = $_GET['vis'];
        if ($currentVis == 1) {
            $toggleTo = 0;
        } else {
            $toggleTo = 1;
        }
        $productDao = \model\database\ProductsDao::getInstance();
        $productDao->toggleVisibility($productId, $toggleTo);

        header("Location: ../../../view/admin/products_promotions_reviews/products_view.php");

    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header('HTTP/1.1 500 Internal Server Error', true, 500);
        die();
    }
} else {
    header('HTTP/1.1 400 Bad Request', true, 400);
    die();
}