<?php

namespace model\database;

use model\database\Connect\Connection;
use model\Favourites;
use PDO;


class FavouritesDao {

    //Делаем синглтон
    private static $instance;
    private $pdo;

    //Определяем запросы, как константы
    const ADD_PRODUCT_TO_FAVOURITES = "INSERT INTO favourites (user_id, product_id) VALUES (?, ?)";

    const REMOVE_PRODUCT_FROM_FAVOURITES = "DELETE FROM favourites WHERE user_id = ? AND product_id = ?";

    const CHECK_IF_IN_FAVOURITES = "SELECT id FROM favourites WHERE user_id = ? AND product_id = ?";

    const ALL_FAVOURITES_BY_USER_ID = "SELECT p.id, p.title, p.description, 
                                       ROUND(IF(MAX(pr.percent) IS NOT NULL, 
                                       p.price - MAX(pr.percent)/100*p.price, p.price), 2) 
                                       price, MIN(i.image_url) image_url, f.user_id, p.visible,
                                       p.subcategory_id FROM products p 
                                       JOIN favourites f ON p.id = f.product_id 
                                       JOIN images i ON p.id = i.product_id 
                                       LEFT JOIN promotions pr ON p.id = pr.product_id 
                                       GROUP BY f.id HAVING f.user_id = ? AND p.visible = 1 AND p.subcategory_id
                                       IS NOT NULL";

    const SUBSCRIBED_USERS_BY_PRODUCT_ID = "SELECT u.email FROM users u LEFT JOIN favourites f ON u.id = f.user_id 
                                            WHERE f.product_id = ?";


    private function __construct() {
        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new FavouritesDao();
        }
        return self::$instance;
    }


    function addFavourite(Favourites $favourite) {

        $statement = $this->pdo->prepare(self::ADD_PRODUCT_TO_FAVOURITES);
        $statement->execute(array($favourite->getUserId(),
                                  $favourite->getProductId()));
    }


    function removeFavourite(Favourites $favourite) {

        $statement = $this->pdo->prepare(self::REMOVE_PRODUCT_FROM_FAVOURITES);
        $statement->execute(array($favourite->getUserId(),
                                  $favourite->getProductId()));
    }


    function checkFavourites(Favourites $favourite) {

        $statement = $this->pdo->prepare(self::CHECK_IF_IN_FAVOURITES);
        $statement->execute(array(
            $favourite->getUserId(),
            $favourite->getProductId()));

        if ($statement->rowCount()) {

            return 1;
        } else {

            return 2;
        }
    }

    function getAllFavourites (Favourites $favourites) {

        $statement = $this->pdo->prepare(self::ALL_FAVOURITES_BY_USER_ID);
        $statement->execute(array(
            $favourites->getUserId()));

        $favouritesUser = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $favouritesUser;
    }

    function subscribedUsersForProduct ( $proudctId) {

        $statement = $this->pdo->prepare(self::SUBSCRIBED_USERS_BY_PRODUCT_ID);
        $statement->execute(array($proudctId));

        $subscribedUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $subscribedUsers;
    }

}
