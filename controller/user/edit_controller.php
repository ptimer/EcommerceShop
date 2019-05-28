<?php

require_once '../../utility/error_handler.php';

require_once "../../utility/no_session_main.php";

require_once "../../utility/imageCrop.php";

//Автолоадинг классов
function __autoload($className){
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}



//Аватар

$imagesDirectory = null;
$tmpName = null;
$userId = $_SESSION['loggedUser'];
$picture = null;

//Проверяем загружен ли файл
if (!empty($_FILES['image']['tmp_name'])) {

    $picture = true;
    $tmpName = $_FILES['image']['tmp_name'];

    //Удачно загружен ?
    if (!is_uploaded_file($tmpName)) {
        header('Location: ../../view/error/error_400.php');
        die();
    }

    //Получаем информацию об изображении
    $fileFormat = mime_content_type($tmpName);
    $type = explode("/", $fileFormat)[0];
    $extension = explode("/", $fileFormat)[1];
    $fileSize = filesize($tmpName);

    if (!($extension == "jpeg" || $extension == "jpg" || $extension == "png" || $extension == "gif")) {
 
        header('Location: ../../view/user/edit.php?errorUL');
        die();
    }

    //Валидация изображения (не должно превышать 5мб)
    if ($type == "image" && $fileSize < 5048576) {
        $uploadTime = microtime();
        $imagesDirectory = "../../web/uploads/profileImage/$userId-$uploadTime.$extension";
    } else {

        header('Location: ../../view/user/edit.php?errorUL');
        die();
    }
} else {
    $picture = false;
}


if (empty($_POST['password'])) {
    $_POST['password'] = false;
}

//Адрес валидация
if (!empty($_POST['personal'])) {
    if (!($_POST['personal'] == 1 || $_POST['personal'] == 2)) {

        header('Location: ../../view/error/error_400.php');
        die();
    }
} else {
    $_POST['personal'] = 0;
}

if (!empty($_POST['address'])) {
    if (!(strlen($_POST['address']) > 4 && strlen($_POST['address']) < 200)) {
 
        header("Location: ../../view/user/edit.php?errorAR");
        die();
    }
} else {
    $_POST['address'] = 0;
}




if (!empty($_POST['email']) && (!empty($_POST['password']) || $_POST['password'] === false) && !empty($_POST['firstName'])
    && !empty($_POST['lastName']) && !empty($_POST['mobilePhone'])) {


    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $mobilePhone = $_POST['mobilePhone'];

    //Email валидация
    if (!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 3 && strlen($email) < 254)) {

        header('Location: ../../view/error/error_400.php');
        die();
    }

    //валидация пароль
    if (!((strlen($password) >= 4 && strlen($password) <= 20) || $password === false)) {
        //Redirect password input error edit
        header('Location: ../../view/user/edit.php?errorPassSyntax');
        die();
    }

    if (!(strlen($firstName) >= 4 && strlen($firstName) < 20)) {

        header('Location: ../../view/user/edit.php?errorFN');
        die();
    }

    if (!(strlen($lastName) >= 4 && strlen($lastName) < 20)) {

        header('Location: ../../view/user/edit.php?errorLN');
        die();
    }

    if (!(ctype_digit($mobilePhone) && strlen($mobilePhone) == 10)) {

        header('Location: ../../view/user/edit.php?errorMN');
        die();
    }

    $user = new \model\User();

    //Пытаемся подкл к бд
    try {

        $userDao = \model\database\UserDao::getInstance();

        $user->setEmail(htmlentities($email));
        $user->setFirstName(htmlentities($firstName));
        $user->setLastName(htmlentities($lastName));
        $user->setMobilePhone(htmlentities($mobilePhone));
        $user->setId($userId);
        $user->setAddress(htmlentities($_POST['address']));
        $user->setPersonal(htmlentities($_POST['personal']));

        //проверяем информацию о пользователе
        $userArr = $userDao->getUserInfo($user);

        //правильный ли пароль ?
        if (sha1($_POST['passwordOld']) == $userArr['password']) {


            if ($password === false) {
                $user->setPassword($userArr['password']);
            } else {
                $user->setPassword(sha1($_POST['password']));
            }


            if ($picture) {
                $user->setImageUrl($imagesDirectory);
            } else {
                $user->setImageUrl($userArr['image_url']);
            }


            if (!empty($_POST['address'])) {
                $user->setAddress(htmlentities($_POST['address']));
            } else {
                $user->setAddress(0);
            }


            if (!empty($_POST['personal'])) {
                $user->setPersonal(htmlentities($_POST['personal']));
            } else {
                $user->setPersonal(0);
            }


            if ($userDao->checkUserExist($user) && $userArr['email'] != $user->getEmail()) {

                header("Location: ../../view/user/edit.php?errorEmail");
                die();
            } else {

                $user->setRole($userArr['role']);

                $userDao->editUser($user);

                //Перемещаем файл в папку
                if ($picture) {
                    move_uploaded_file($tmpName, $imagesDirectory);
                    cropImage($imagesDirectory, 200);
                }


                if(isset($_GET['addAddress'])) {
                    header("Location: ../../view/main/checkout.php");
                    die();
                } else {
                    header("Location: ../../view/main/index.php");
                    die();
                }
            }
        } else {

            header("Location: ../../view/user/edit.php?errorPassMatch");
            die();
        }
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../errors.log');
        header("Location: ../../view/error/error_500.php");
        die();
    }
} else {

    header('Location: ../../view/error/error_400.php');
    die();
}