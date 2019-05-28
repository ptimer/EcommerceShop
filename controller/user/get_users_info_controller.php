<?php

require_once '../../utility/error_handler.php';

require_once "../../utility/no_session_main.php";

//Автолоадинг классов
function __autoload($className) {
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}



$user = new \model\User();

//Пытаемся подкл к бд
try {
    $userDao = \model\database\UserDao::getInstance();

    $user->setId($_SESSION['loggedUser']);

    $userArr = $userDao->getUserInfo($user);


} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
    error_log($message, 3, '../../errors.log');
    header("Location: ../../view/error/error_500.php");
    die();
}