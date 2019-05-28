<?php

require_once '../../utility/error_handler.php';

session_start();

if(isset($_SESSION['loggedUser'])) {

    // Autoload объявлен в single_product_controller

    $favourites = new \model\Favourites();

//Пытаемся подкл к бд
    try {

        $favouritesDao = \model\database\FavouritesDao::getInstance();

        $favourites->setUserId($_SESSION['loggedUser']);
        $favourites->setProductId($product['id']);

        $isFavourite = $favouritesDao->checkFavourites($favourites);


} catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../errors.log');
        header("Location: ../../view/error/error_500.php");
        die();
    }

} else {

    // Когда 3, это значит, что пользователь не авторизован
    $isFavourite = 3;
}