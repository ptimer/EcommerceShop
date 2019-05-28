<?php

require_once '../../utility/error_handler.php';

//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

if (isset ($_GET['filter'])) {
    $offset = $_GET['offset'];
    $subcatId = $_GET['subcid'];
    $filter = $_GET['filter'];
    $minPrice = $_GET['minP'];
    $maxPrice = $_GET['maxP'];

    try {

        $productsDao = \model\database\ProductsDao::getInstance();
        $products = $productsDao->getSubCatProducts($subcatId, $offset, $filter, $minPrice, $maxPrice);

    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../errors.log');
        header('HTTP/1.1 500 Internal Server Error', true, 500);
        die();
    }

    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    try {

        $subcatDao = \model\database\SubCategoriesDao::getInstance();
        $subcatName = $subcatDao->getSubCategoryName($_GET['subcid']);

    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../errors.log');
        header("Location: ../../view/error/error_500.php");
        die();
    }
}