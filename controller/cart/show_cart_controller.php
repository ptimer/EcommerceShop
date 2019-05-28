<?php

require_once '../../utility/error_handler.php';

session_start();
//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $cartIsEmpty = 0;
} else {
    $cart = array();
    $cartIsEmpty = 1;
}

if (isset($_SESSION['oid'])) {
    $orderNumber = $_SESSION['oid'];
    $orderQuantity = $_SESSION['oItems'];
    $orderTotalPrice = $_SESSION['oTotalPrice'];
    unset($_SESSION['oid']);
    unset($_SESSION['oItems']);
    unset($_SESSION['oTotalPrice']);
    $orderSuccessful = 1;
} else {
    $orderSuccessful = 0;
}