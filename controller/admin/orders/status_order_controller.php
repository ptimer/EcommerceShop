<?php

require_once '../../../utility/error_handler_dir_back.php';


require_once '../../../utility/admin_mod_session.php';
//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}


if (isset($_GET['oid'])) {


    try {
        $orderId = $_GET['oid'];
        $newStatus = $_GET['ns'];
        $orderDao = \model\database\OrdersDao::getInstance();
        $userEmail = $orderDao->changeOrderStatus($orderId, $newStatus);

        if (!($newStatus == 1 || $newStatus == 2 || $newStatus == 3 || $newStatus == 4)) {
            header('HTTP/1.1 400 Bad Request', true, 400);
            die();
        }

        if ($newStatus == 2) {
            $status = "has been send!";
        } elseif ($newStatus == 3) {
            $status = "has been delivered!";
        } elseif ($newStatus == 4) {
            $status = "has been canceled";
        }

        if ($newStatus != 1) {
            require_once 'send_status_change.php';
        }



    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
} else {
    header('HTTP/1.1 400 Bad Request', true, 400);
    die();
}