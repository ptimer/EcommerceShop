<?php

require_once '../../utility/error_handler.php';

if (!function_exists("__autoload")) {
    function __autoload($className)
    {
        $className = '..\\..\\' . $className;
        require_once str_replace("\\", "/", $className) . '.php';
    }
}

session_start();

if (isset($_SESSION['cart'])) {

    $cart = $_SESSION['cart'];

    $products = array();

    foreach ($cart as $key => $value) {
        $products[$key]['id'] = $value->getId();
        $products[$key]['image_url'] = $value->getImage();
        $products[$key]['title'] = $value->getTitle();
        $products[$key]['price'] = $value->getPrice();
        $products[$key]['quantity'] = $value->getQuantity();

    }

    echo json_encode($products, JSON_UNESCAPED_SLASHES);
} else {
    echo json_encode(array());
}