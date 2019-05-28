<?php

require_once '../../utility/error_handler.php';
//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

$product = null;

//Пытаемся подкл к бд
try {
    $productId = $_GET['pid'];
    $productsDao = \model\database\ProductsDao::getInstance();
    $specsDao = \model\database\ProductSpecificationsDao::getInstance();
    $reviewsDao = \model\database\ReviewsDao::getInstance();
    $imagesDao = \model\database\ProductImagesDao::getInstance();
    $promoDao = \model\database\PromotionsDao::getInstance();

    $product = $productsDao->getProductByID($productId);
    if ($product['visible'] == 0) {
        header("Location: ../../view/error/error_404.php");
        die();
    }
    $specifications = $specsDao->getAllSpecificationsForProduct($productId);
    $reviews = $reviewsDao->getReviewsForProduct($productId);
    $images = $imagesDao->getAllProductImages($productId);
    $promotion = $promoDao->getBiggestActivePromotionByProductId($productId);
    $reviewsCount = count($reviews);
    $relatedProducts = $productsDao->getRelated($product['subcategory_id'], $productId);

    $promotedPrice = null;
    if ($promotion != null) {
        $promotedPrice = round($product['price'] - (($product['price'] * $promotion['percent']) / 100), 2);
    }

    // Проверяем если рейтинг не нулл
    if ($product['average'] === null) {
        $product['average'] = 0;
    } else {
        $product['average'] = round($product['average'], 0);
    }

} catch (PDOException $e) {
    $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
    error_log($message, 3, '../../errors.log');
    header("Location: ../../view/error/error_500.php");
    die();
}