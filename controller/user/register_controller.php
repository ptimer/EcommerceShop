<?php

require_once '../../utility/error_handler.php';

require_once '../../utility/session_main.php';
//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}


//Валидация
if (!empty($_POST['email']) &&
    !empty($_POST['password']) &&
    !empty($_POST['password2']) &&
    !empty($_POST['firstName']) &&
    !empty($_POST['lastName']) &&
    !empty($_POST['mobilePhone'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $mobilePhone = $_POST['mobilePhone'];

    // Перенаправляем на ошибки в зависимости от неправильно введенного поля

    if (!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 3 && strlen($email) < 254)) {


        header("Location: ../../view/error/error_400.php");
        die();
    }

    if (!(ctype_digit($mobilePhone) && strlen($mobilePhone) == 10)) {


        header("Location: ../../view/user/register.php?errorMN");
        die();
    }

    if (!(strlen($password) >= 4 && strlen($password) < 20 && strlen($password2) >= 4 && strlen($password2) < 20)) {

        header("Location: ../../view/user/register.php?errorPassSyntax");
        die();
    }

    if (!($password == $password2)) {

        header("Location: ../../view/user/register.php?errorPassMatch");
        die();
    }

    if (!(strlen($firstName) >= 4 && strlen($firstName) < 20)) {

        header("Location: ../../view/user/register.php?errorFN");
        die();
    }

    if (!(strlen($lastName) >= 4 && strlen($lastName) < 20)) {

        header("Location: ../../view/user/register.php?errorLN");
        die();
    }



    $user = new \model\User();

    //Пытаемся подкл к бд
    try {
        $userDao = \model\database\UserDao::getInstance();

        $user->setEmail(htmlentities($email));
        $user->setPassword(sha1($password));
        $user->setFirstName(htmlentities($firstName));
        $user->setLastName(htmlentities($lastName));
        $user->setMobilePhone(htmlentities($mobilePhone));

        //Проверяем роль пользователя
        if($userDao->checkIfUserFirst()) {
            $user->setRole(3);
            $_SESSION['role'] = 3;
        } else {
            $user->setRole(1);
            $_SESSION['role'] = 1;
        }

        $_SESSION['enabled'] = 1;


        if ($userDao->checkUserExist($user)) {


            header("Location: ../../view/user/register.php?errorEmail");
            die();
        } else {

            $id = $userDao->registerUser($user);
            $_SESSION['loggedUser'] = $id;

            header("Location: ../../view/main/index.php");
            die();
        }

    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../errors.log');
        header("Location: ../../view/error/error_500.php");
        die();
    }

} else {

    header("Location: ../../view/error/error_400.php");
    die();
}


