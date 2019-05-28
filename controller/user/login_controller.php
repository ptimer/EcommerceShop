<?php

require_once '../../utility/error_handler.php';

require_once '../../utility/session_main.php';

//Автолоадинг классов
function __autoload($className) {

    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}


//Валидация
if (!empty($_POST['email']) &&
    !empty($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (strlen($email) > 3 &&
        strlen($email) < 254 &&
        strlen($password) >= 4 &&
        strlen($password) <= 12) {



        $user = new \model\User();

        //Пытаемся подкл к бд
        try {
            $userDao = \model\database\UserDao::getInstance();

            $user->setEmail(htmlentities($email));
            $user->setPassword(sha1($password));

            $result = $userDao->checkLogin($user);

            if ($result) {

 
                if (!$userDao->checkEnabled($result)) {

                    header("Location: ../../view/user/login.php?blocked");
                    die();
                }


                $_SESSION['loggedUser'] = $result;
                $_SESSION['role'] = 1;
                $userDao->setLastLogin($user);


                //Проверяем админ ли юзер
                if($userDao->checkIfLoggedUserIsAdmin($user) == 3) {
                    $_SESSION['role'] = 3;
                } elseif ($userDao->checkIfLoggedUserIsAdmin($user) == 2) {
                    $_SESSION['role'] = 2;
                } else {
                    $_SESSION['role'] = 1;
                }


                header("Location: ../../view/main/index.php");
                die();
            } else {

                header("Location: ../../view/user/login.php?error");
                die();
            }


        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header("Location: ../../view/error/error_500.php");
            die();
        }
    } else {


        header("Location: ../../view/user/login.php?error");
        die();
    }
} else {

    header("Location: ../../view/user/login.php?error_400");
    die();
}