<?php

require_once '../../utility/error_handler.php';


if (!function_exists("__autoload")) {
    function __autoload($className)
    {
        $className = '..\\..\\' . $className;
        require_once str_replace("\\", "/", $className) . '.php';
    }
}

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $cartItems = 0;
    $cartTotalPrice = 0;
    foreach ($cart as $cartProduct) {
        $cartItems += $cartProduct->getQuantity();
        $cartTotalPrice += $cartProduct->getPrice() * $cartProduct->getQuantity();
    }


} else {
    $cartItems = "0";
    $cartTotalPrice = "0.00";
}