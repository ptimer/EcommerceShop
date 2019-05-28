<?php

require_once '../../../utility/error_handler_dir_back.php';

require_once '../../../utility/admin_mod_session.php';
//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}
if (isset($_GET['prid'])) {
  
    try {
        $promoId = $_GET['prid'];
        $promoDao = \model\database\PromotionsDao::getInstance();
        $promoDao->deletePromotion($promoId);
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