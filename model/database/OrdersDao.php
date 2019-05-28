<?php


namespace model\database;

use model\database\Connect\Connection;
use model\Order;
use PDO;

class OrdersDao
{
    //Делаем синглтон
    private static $instance;
    private $pdo;

    //Определяем запросы, как константы
    const ADD_NEW_ORDER = "INSERT INTO orders (user_id, created_at, status) VALUES (?, ?, ?)";

    const ADD_ORDER_PRODUCT = "INSERT INTO order_products (order_id, product_id, quantity) VALUES (?, ?, ?)";

    const GET_ALL_ORDERS_ADMIN = "SELECT o.id, u.email AS email, o.created_at, o.status FROM orders o
                                INNER JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC";

    const CHANGE_ORDER_STATUS = "UPDATE orders SET status = ? WHERE id = ?";

    const GET_USER_EMAIL_BY_ORDER = "SELECT u.email FROM users u JOIN orders o ON u.id = o.user_id WHERE o.id = ?";

    const GET_ORDER_DETAILS = "SELECT o.id, u.email AS email, o.created_at, o.status, p.title AS product, op.quantity 
                              AS quantity, p.id AS product_id, u.id AS user_id FROM orders o
                              INNER JOIN users u ON o.user_id = u.id
                              INNER JOIN order_products op ON op.order_id = o.id
                              INNER JOIN products p ON op.product_id = p.id
                              WHERE o.id = ?";

    private function __construct()
    {

        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance()
    {

        if (self::$instance === null) {
            self::$instance = new OrdersDao();
        }

        return self::$instance;
    }

    function newOrder(Order $order, $cart)
    {
        $this->pdo->beginTransaction();

        try {
            //создаем новый заказ и получаем id
            $statement = $this->pdo->prepare(self::ADD_NEW_ORDER);
            $statement->execute(array($order->getUserId(), $order->getCreatedAt(), $order->getStatus()));
            $orderId = $this->pdo->lastInsertId();

            //заполняем заказ с товарами и возвращаем id, общую цену, количество, как массив
            $totalPrice = 0;
            $quantity = 0;
            foreach ($cart as $cartProduct) {
                $totalPrice += $cartProduct->getPrice() * $cartProduct->getQuantity();
                $quantity += $cartProduct->getQuantity();

                $statement = $this->pdo->prepare(self::ADD_ORDER_PRODUCT);
                $statement->execute(array($orderId, $cartProduct->getId(), $cartProduct->getQuantity()));
            }

            $statement = $this->pdo->prepare(self::GET_USER_EMAIL_BY_ORDER);
            $statement->execute(array($orderId));

            $email = $statement->fetch();

            $result = [$orderId, $totalPrice, $quantity, $email[0]];
            $this->pdo->commit();

            return $result;

        } catch (\PDOException $e) {
            $this->pdo->rollBack();
                $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
                error_log($message, 3, '../../errors.log');
                header("Location: ../../view/error/error_500.php");
                die();
        }
    }

    function getAllOrdersAdmin()
    {
        $statement = $this->pdo->prepare(self::GET_ALL_ORDERS_ADMIN);
        $statement->execute();

        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $orders;
    }

    function changeOrderStatus($orderId, $newStatus)
    {
        $statement = $this->pdo->prepare(self::CHANGE_ORDER_STATUS);
        $statement->execute(array($newStatus, $orderId));

        $statement = $this->pdo->prepare(self::GET_USER_EMAIL_BY_ORDER);
        $statement->execute(array($orderId));

        $email = $statement->fetch();

        return $email[0];
    }

    function getOrderDetails($orderId)
    {
        $statement = $this->pdo->prepare(self::GET_ORDER_DETAILS);
        $statement->execute(array($orderId));

        $order = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $order;
    }
}
