<?php
//Проверяем на сессию
require_once "../../utility/session_main.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../../web/assets/css/user.css" type="text/css">
    <link rel="shortcut icon" href="../../web/assets/images/favicon.ico?v4" type="image/x-icon">

    <title>Войти</title>
</head>
<body>

<div class="login-page">
    <div id="logo"><a href="../main/index.php"><img src="../../web/assets/images/logo.png"></a></div>
    <div class="form">
        <form class="login-form" action="../../controller/user/login_controller.php" method="post">
            <input type="email" name="email" placeholder="Введите ваш email" required/>
            <input type="password" name="password" placeholder="Введите ваш пароль"
                   pattern=".{4,20}" required title="Пароль должен быть от 4 до 20 символов"/>

            <input id="login" type="submit" value="Войти">

            <?php if(isset($_GET['error'])){ echo "<p id=\"wrongLogin\">Пользователь не найден!</p>"; };?>
            <?php if(isset($_GET['blocked'])){ echo "<p id=\"wrongLogin\">Пользователь заблокирован!</p>"; };?>
            <p class="message">Не зарегистрированы? <a href="register.php">Создайте аккаунт</a></p>

        </form>
    </div>
</div>

</body>
</html>