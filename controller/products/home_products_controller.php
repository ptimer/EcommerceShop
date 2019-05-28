<?php

require_once '../../utility/error_handler.php';

//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

$product = null;

try {

    $productsDao = \model\database\ProductsDao::getInstance();
    $slidersDao = \model\database\SliderDao::getInstance();

    $topRated = $productsDao->getTopRated();
    $mostRecent = $productsDao->getMostRecent();
    $mostSold = $productsDao->mostSoldProducts();
    $products = $productsDao->getAllProductsGuest();

    $slides = $slidersDao->getAllSliders();


} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
    error_log($message, 3, '../../errors.log');
    header("Location: ../../view/error/error_500.php");
    die();
}