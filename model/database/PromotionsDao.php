<?php
namespace model\database;
use model\database\Connect\Connection;
use model\Promotion;
use PDO;
class PromotionsDao
{
   //Делаем синглтон
    private static $instance;
    private $pdo;
    //Определяем запросы, как константы
    const CREATE_PROMOTION = "INSERT INTO promotions (percent, start_date, end_date, product_id) VALUES (?, ?, ?, ?)";
    const BIGGEST_ACTIVE_BY_PRODUCT_ID = "SELECT percent, start_date, end_date FROM promotions 
                                          WHERE product_id = ? AND start_date <= now() AND end_date >= now() 
                                          ORDER BY percent DESC LIMIT 1";
    const GET_ALL_PROMOS_FOR_PRODUCT_ADMIN = "SELECT * FROM promotions WHERE product_id = ?";
    const DELETE_PROMOTION = "DELETE FROM promotions WHERE id = ?";

    private function __construct()
    {
        $this->pdo = Connection::getInstance()->getConnection();
    }
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new PromotionsDao();
        }
        return self::$instance;
    }
    function createPromotion(Promotion $promotion)
    {
        $statement = $this->pdo->prepare(self::CREATE_PROMOTION);
        $statement->execute(array(
                $promotion->getPercent(),
                $promotion->getStartDate(),
                $promotion->getEndDate(),
                $promotion->getProductId())
        );
        $promoId = $this->pdo->lastInsertId();
        return $promoId;
    }
    function getBiggestActivePromotionByProductId($productId)
    {
        $statement = $this->pdo->prepare(self::BIGGEST_ACTIVE_BY_PRODUCT_ID);
        $statement->execute(array($productId));
        $promotion = $statement->fetch();
        return $promotion;
    }
    function getAllPromotionsForProduct($productId)
    {
        $statement = $this->pdo->prepare(self::GET_ALL_PROMOS_FOR_PRODUCT_ADMIN);
        $statement->execute(array($productId));
        $promotions = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $promotions;
    }
    function deletePromotion($promoId)
    {
        $statement = $this->pdo->prepare(self::DELETE_PROMOTION);
        $statement->execute(array($promoId));
        return true;
    }
}