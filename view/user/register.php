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

    <title>Регистрация</title>
</head>
<body>

<div class="login-page">
    <div id="logo"><a href="../main/index.php"><img src="../../web/assets/images/logo.png"></a></div>
    <div class="form">
        <form class="login-form" action="../../controller/user/register_controller.php" method="post">

            <p class="wrongInput" <?= (!isset($_GET['errorField'])) ?:"style='display: block;'"?>>
                Нужно заполнить все поля!</p>
            <input type="email" name="email" placeholder="Ваш Email"  required/>
            <p class="wrongInput" <?= (!isset($_GET['errorEmail'])) ?:"style='display: block;'"?>>
                Email уже существует!</p>

            <input type="password" name="password" placeholder="Ваш пароль"
                   pattern=".{4,20}" required title="Password 4 to 20 characters"/>
            <p class="wrongInput" <?= (!isset($_GET['errorPassSyntax'])) ?:"style='display: block;'"?>>
                Пароль должен быть от 4 до 20 символов!</p>
            <p class="wrongInput" <?= (!isset($_GET['errorPassMatch'])) ?:"style='display: block;'"?>>
                Пароли не совпадают!</p>

            <input type="password" name="password2" placeholder="Повторите пароль"
                   pattern=".{4,20}" required title="Пароль должен быть от 4 до 20 символов"/>

            <input type="text" name="firstName" placeholder="Имя"
                   pattern=".{4,20}" required title="Имя должно быть от 4 до 20 символов"/>
            <p class="wrongInput"  <?= (!isset($_GET['errorFN'])) ?:"style='display: block;'"?>>
                Имя должно быть от 4 до 20 символов!</p>

            <input type="text" name="lastName" placeholder="Фамилия"
                   pattern=".{4,20}" required title="Фамилия должна быть от 4 до 20 символов"/>
            <p class="wrongInput"  <?= (!isset($_GET['errorLN'])) ?:"style='display: block;'"?>>
                Фамилия должна быть от 4 до 20 символов!</p>

            <input type="tel" name="mobilePhone" placeholder="Телефон"
                   pattern="[0-9]{10}" required title="Телефон должен содержать 10 цифр"/>
            <p class="wrongInput"  <?= (!isset($_GET['errorMN'])) ?:"style='display: block;'"?>>
                Телефон должен содержать 10 цифр!</p>

            <input id="login" type="submit" value="Зарегистрироваться">
            <p class="message">Уже зарегистрированы? <a href="login.php">&nbspВойти</a></p>
        </form>
    </div>
</div>

</body>
</html>