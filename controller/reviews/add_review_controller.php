<?php

require_once '../../utility/error_handler.php';

session_start();

if (isset($_SESSION['loggedUser'])) {

//Автолоадинг классов
    function __autoload($className)
    {
        $className = '..\\..\\' . $className;
        require_once str_replace("\\", "/", $className) . '.php';
    }

    //Валидация

    if (isset($_POST['rating']) && isset($_POST['title']) && isset($_POST['review']) && isset($_GET['pid'])
        && strlen($_POST['review']) >= 3 && strlen($_POST['review']) <= 3000
        && strlen($_POST['title']) > 3 && strlen($_POST['title']) < 500
        && $_POST['rating'] >= 1 && $_POST['rating'] <= 5) {

        $review = new \model\Reviews();

        $review->setRating(htmlentities($_POST['rating']));
        $review->setTitle(htmlentities($_POST['title']));
        $review->setComment(htmlentities($_POST['review']));
        $review->setUserId($_SESSION['loggedUser']);
        $review->setProductId($_GET['pid']);

        try {
            $reviewDao = \model\database\ReviewsDao::getInstance();
            $reviewDao->addNewReview($review);

            header("Location: ../../view/main/single.php?pid=" . $_GET['pid']);
            die();

        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header("Location: ../../view/error/error_500.php");
            die();
        }
    } else {

        header ("Location: ../../view/error/error_400.php");
        die();
    }


} else {

    header("Location: ../../view/main/index.php");
    die();
}