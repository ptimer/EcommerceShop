<?php

namespace model\database;

use model\database\Connect\Connection;
use model\User;
use PDO;
use PDOException;

class UserDao
{


    private static $instance;
    private $pdo;


  
    const CHECK_LOGIN = "SELECT id, email, password FROM users WHERE email = ? AND password = ?";

    const CHECK_USER_EXIST = "SELECT id FROM users WHERE email = ?";

    const REGISTER_USER = "INSERT INTO users (email, enabled, first_name, last_name, mobile_phone,
                           image_url, password, last_login, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    const REGISTER_USER_ADDRESS = "INSERT INTO adresses (full_adress, is_personal, user_id) VALUES (?, ?, ?)";

    const EDIT_USER = "UPDATE users SET email = ?, enabled = ?, first_name = ?, last_name = ?, mobile_phone = ?,
                           image_url = ?, password = ?, role = ? WHERE id = ?";

    const UPDATE_ADDRESS = "UPDATE adresses SET full_adress = ?, is_personal = ? WHERE user_id = ?";

    const CHECK_ADDRESS_SET = "SELECT id FROM adresses WHERE NOT full_adress = '0' AND user_id = ?";

    const GET_USER_INFO = "SELECT u.id, u.email, u.enabled, u.first_name, u.last_name, u.mobile_phone, u.image_url, 
                                  u.password, u.last_login, u.role, a.full_adress, a.is_personal  FROM users AS u 
                                  JOIN adresses AS a ON u.id = a.user_id WHERE a.user_id = ?";

    const SET_LAST_LOGIN = "UPDATE users SET last_login = ? WHERE email = ?";

    const IS_FIRST_USER = "SELECT id FROM users";

    const ROLE = "SELECT role FROM users WHERE email = ? AND password = ?";

    const RESET_PASS = "UPDATE users SET password = ? WHERE email = ?";

    const GET_ALL_USERS_ADMIN = "SELECT * FROM users";

    const GET_USER_DETAILS_ADMIN = "SELECT u.id, u.email, u.first_name, u.last_name, u.mobile_phone, u.image_url, 
                                  u.last_login, a.full_adress, a.is_personal 
                                  FROM users u JOIN adresses a ON a.user_id = u.id  WHERE u.id = ?";

    const GET_USER_ORDERS_ADMIN = "SELECT * FROM orders WHERE user_id = ?";

    const BAN_UNBAN_USER = "UPDATE users SET enabled = ? WHERE id = ?";

    const MAKE_UNMAKE_MODERATOR_USER = "UPDATE users SET role = ? WHERE id = ?";

    const CHECK_ENABLED = "SELECT id FROM users WHERE id = ? AND enabled = 1";



    private function __construct()
    {

        $this->pdo = Connection::getInstance()->getConnection();
    }

    public static function getInstance()
    {

        if (self::$instance === null) {
            self::$instance = new UserDao();
        }
        return self::$instance;
    }


    function checkLogin(User $user)
    {

        $statement = $this->pdo->prepare(self::CHECK_LOGIN);
        $statement->execute(array(
            $user->getEmail(),
            $user->getPassword()));

        if ($statement->rowCount()) {

            $userId = $statement->fetch();
            return (int)$userId['id'];
        } else {

            return false;
        }
    }


    function checkEnabled($id)
    {

        $statement = $this->pdo->prepare(self::CHECK_ENABLED);
        $statement->execute(array($id));

        if ($statement->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    function checkUserExist(User $user)
    {

        $statement = $this->pdo->prepare(self::CHECK_USER_EXIST);
        $statement->execute(array($user->getEmail()));
        // проверяем если база вернет пользователя (1 или 0 колонок)
        if ($statement->rowCount()) {
            return true;
        } else {
            return false;
        }
    }


    function registerUser(User $user)
    {


        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare(self::REGISTER_USER);
            $statement->execute(array(
                $user->getEmail(),
                $user->getEnabled(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getMobilePhone(),
                $user->getImageUrl(),
                $user->getPassword(),
                $user->getLastLogin(),
                $user->getRole()));

            $lastInsertId = $this->pdo->lastInsertId();

            $statement = $this->pdo->prepare(self::REGISTER_USER_ADDRESS);
            $statement->execute(array(
                $user->getAddress(),
                $user->getPersonal(),
                $lastInsertId));


            $this->pdo->commit();

            return $lastInsertId;
        } catch (PDOException $e) {

            $this->pdo->rollBack();
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, 'errors.log');
            header("Location: ../../view/error/error_500.php");
            die();
        }
    }



    function editUser(User $user)
    {


        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare(self::EDIT_USER);
            $statement->execute(array(
                $user->getEmail(),
                $user->getEnabled(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getMobilePhone(),
                $user->getImageUrl(),
                $user->getPassword(),
                $user->getRole(),
                $user->getId()));

            $statement = $this->pdo->prepare(self::UPDATE_ADDRESS);
            $statement->execute(array(
                $user->getAddress(),
                $user->getPersonal(),
                $user->getId()));

            $this->pdo->commit();
        } catch (PDOException $e) {

            $this->pdo->rollBack();
            header("Location: ../../view/error/error_500.php");
        }
    }



    function checkAddressSet(User $user)
    {

        $statement = $this->pdo->prepare(self::CHECK_ADDRESS_SET);
        $statement->execute(array(
            $user->getId()));

        if ($statement->rowCount()) {

            return true;
        } else {

            return false;
        }
    }


    function getUserInfo(User $user)
    {

        $statement = $this->pdo->prepare(self::GET_USER_INFO);
        $statement->execute(array(
            $user->getId()));

        $userInfo = $statement->fetch();

        return $userInfo;
    }



    function setLastLogin(User $user)
    {

        $statement = $this->pdo->prepare(self::SET_LAST_LOGIN);
        $user->setLastLogin();
        $statement->execute(array(
            $user->getLastLogin(),
            $user->getEmail()));
    }


    function checkIfUserFirst()
    {

        $statement = $this->pdo->prepare(self::IS_FIRST_USER);
        $statement->execute();

        if ($statement->rowCount()) {

            return false;
        } else {

            return true;
        }
    }

    function checkIfLoggedUserIsAdmin(User $user)
    {

        $statement = $this->pdo->prepare(self::ROLE);
        $statement->execute(array(
            $user->getEmail(),
            $user->getPassword()));

        $userRole = $statement->fetch();
        return (int)$userRole['role'];
    }


    function getAllUsersAdmin()
    {
        $statement = $this->pdo->prepare(self::GET_ALL_USERS_ADMIN);
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    function getUserDetailsAdmin($userId)
    {
        $statement = $this->pdo->prepare(self::GET_USER_DETAILS_ADMIN);
        $statement->execute(array($userId));
        $user = $statement->fetch();

        return $user;
    }

    function getUserOrdersAdmin($userId)
    {
        $statement = $this->pdo->prepare(self::GET_USER_ORDERS_ADMIN);
        $statement->execute(array($userId));
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $orders;
    }

    function banUnbanUser($userId, $newStatus)
    {
        $statement = $this->pdo->prepare(self::BAN_UNBAN_USER);
        $statement->execute(array($newStatus, $userId));

        return true;
    }

    function makeUnmakeModUser($userId, $newRole)
    {
        $statement = $this->pdo->prepare(self::MAKE_UNMAKE_MODERATOR_USER);
        $statement->execute(array($newRole, $userId));

        return true;
    }
}