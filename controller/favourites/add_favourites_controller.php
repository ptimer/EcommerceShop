<?php

require_once '../../utility/error_handler.php';


require_once "../../utility/no_session_main.php";

//Автолоадинг классов
function __autoload($className) {
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

if (isset($_SESSION['loggedUser']) && isset($_GET['product_id'])) {

    $userId = $_SESSION['loggedUser'];
    $productId = $_GET['product_id'];

    $favourites = new \model\Favourites();

    try {

        $favouritesDao = \model\database\FavouritesDao::getInstance();

        $favourites->setUserId($userId);
        $favourites->setProductId($productId);

        $favouritesDao->addFavourite($favourites);



    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../errors.log');
        header("Location: ../../view/error/error_500.php");
        die();
    }

} else {
    header("Location: ../../view/error/error_400.php");
    die();
}