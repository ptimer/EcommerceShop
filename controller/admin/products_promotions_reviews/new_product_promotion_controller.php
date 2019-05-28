<?php

require_once '../../../utility/error_handler_dir_back.php';

require_once '../../../utility/admin_mod_session.php';
//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}
if (isset($_POST['submit'])) {
    //Валидация
    if (empty($_POST['percent']) ||
        empty($_POST['start_date']) ||
        empty($_POST['end_date']) ||
        empty($_POST['product_id']) ) {
        header('Location: ../../../view/error/error_400.php');
        die();
    }
    $percent = $_POST['percent'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $productId = $_POST['product_id'];
    $promotion = new \model\Promotion($percent, $startDate, $endDate, $productId);

    try {
        $promoDao = \model\database\PromotionsDao::getInstance();
        $favDao = \model\database\FavouritesDao::getInstance();
        $productsDao = \model\database\ProductsDao::getInstance();
        $id = $promoDao->createPromotion($promotion);
        $productInfo = $productsDao->getProductByID($productId);
        $subscribedUsers = $favDao->subscribedUsersForProduct($productId);

        if (!empty($subscribedUsers)) {
     
            require_once 'send_promotion_controller.php';
        }
        header("Location: ../../../view/admin/products_promotions_reviews/promotions_product_view.php?pid=" . $productId);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
} else {
    header("Location: ../../../view/error/error_400.php");
    die();
}