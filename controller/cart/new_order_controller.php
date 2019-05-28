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
    //Валидация на авторизацию
    if(!empty($_SESSION['loggedUser'])) {
        $userId = $_SESSION['loggedUser'];
    } else {
        header('Location: ../../view/user/login.php');
        die();
    }
    //Валидация на адрес
    $userDao = \model\database\UserDao::getInstance();
    $user = new \model\User();
    $user->setId($userId);
    if(!($userDao->checkAddressSet($user))) {
        header('Location: ../../view/user/edit.php?addAddress#address');
        die();
    }
    $order = new \model\Order($userId, $cart);
    try {
        $ordersDao = \model\database\OrdersDao::getInstance();
        $result = $ordersDao->newOrder($order, $cart);
        if ($result === false) {
            header("Location: ../../view/error/error_500.php");
            die();
        }
        $orderId = $result[0];
        $totalPrice = $result[1];
        $quantity = $result[2];
        $userEmail = $result[3];
        unset($_SESSION['cart']);
        $_SESSION['oid'] = $orderId;
        $_SESSION['oItems'] = $quantity;
        $_SESSION['oTotalPrice'] = $totalPrice;
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../errors.log');
        header("Location: ../../view/error/error_500.php");
        die();
    }
    header("Location: ../../view/main/checkout.php");
    die();
} else {
    header("Location: ../../view/error/error_400.php");
    die();
}