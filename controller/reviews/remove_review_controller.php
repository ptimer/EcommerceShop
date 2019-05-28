<?php

require_once '../../utility/error_handler.php';

session_start();

if (isset($_SESSION['loggedUser']) && ($_SESSION['role'] == 3 || $_SESSION['role'] == 2)) {

//Автолоадинг классов
    function __autoload($className)
    {
        $className = '..\\..\\' . $className;
        require_once str_replace("\\", "/", $className) . '.php';
    }


        try {
            $reviewDao = \model\database\ReviewsDao::getInstance();
            $reviewDao->removeReview($_GET['rev']);

        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header("Location: ../../view/error/error_500.php");
            die();
        }


} else {

    header("Location: ../../view/error/error_403.php");
    die();
}
