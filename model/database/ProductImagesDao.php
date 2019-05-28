<?php


namespace model\database;

use model\database\Connect\Connection;
use PDO;

class ProductImagesDao {

    //Делаем синглтон
    private static $instance;
    private $pdo;

    //Определяем запросы, как константы
    const ADD_PRODUCT_IMAGE = "INSERT INTO images (image_url, product_id) VALUES (?, ?)";

    const GET_PRODUCT_IMAGES = "SELECT image_url FROM images WHERE product_id = ?";

    const GET_FIRST_IMAGE = "SELECT image_url FROM images WHERE product_id = ? LIMIT 1";


    private function __construct() {
        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {

        if (self::$instance === null) {
            self::$instance = new ProductImagesDao();
        }

        return self::$instance;
    }


    function addProductImage(ProductImage $image) {

        $statement = $this->pdo->prepare(self::ADD_PRODUCT_IMAGE);
        $statement->execute(array(
            $image->getImageUrl(),
            $image->getProductId()));
    }

    function getAllProductImages($productId) {

        $statement = $this->pdo->prepare(self::GET_PRODUCT_IMAGES);
        $statement->execute(array($productId));
        $images = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $images;
    }



    function getFirstProductImage($productId) {

        $statement = $this->pdo->prepare(self::GET_FIRST_IMAGE);
        $statement->execute(array($productId));
        $image = $statement->fetch();

        return $image['image_url'];
    }
}

