<?php
// Запрашиваем старую информацию и проверяем на сессию
require_once "../../controller/user/get_users_info_controller.php";

//Проверяем не заблокирован ли юзер
require_once "../../utility/blocked_user.php";

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

    <title>Редактировать</title>
</head>
<body>

<div class="login-page">
    <div id="logo"><a href="../main/index.php"><img src="../../web/assets/images/logo.png"></a></div>
    <div class="form">
        <form enctype="multipart/form-data" class="login-form"
              action="../../controller/user/edit_controller.php<?php if(isset($_GET['addAddress'])){ echo "?addAddress" ;}?>"
              method="post">

            <input type="email" name="email" value="<?= $userArr["email"] ?>" required/>
            <p class="wrongInput" <?= (!isset($_GET['errorEmail'])) ?:"style='display: block;'"?>>
                Email уже существует!</p>

            <input type="password" name="passwordOld" placeholder="Ваш текущий пароль"
                   pattern=".{4,20}" required title="Password 4 to 20 characters"/>
            <p class="wrongInput" <?= (!isset($_GET['errorPassMatch'])) ?:"style='display: block;'"?>>
                Неверный пароль!</p>

            <input type="password" name="password" placeholder="Новый пароль (необязательно)"
                   pattern=".{4,20}" title="Пароль от 4 до 20 символов"/>
            <p class="wrongInput" <?= (!isset($_GET['errorPassSyntax'])) ?:"style='display: block;'"?>>
                Пароль должен быть от 4 до 20 символов!</p>

            <input type="text" name="firstName" value="<?= $userArr["first_name"] ?>"
                   pattern=".{4,20}" required title="Имя должно быть от 4 до 20 символов"/>
            <p class="wrongInput"  <?= (!isset($_GET['errorFN'])) ?:"style='display: block;'"?>>
                Имя должно быть от 4 до 20 символов!</p>

            <input type="text" name="lastName" value="<?= $userArr["last_name"] ?>"
                   pattern=".{4,20}" required title="Фамилия должна быть от 4 до 20 символов"/>
            <p class="wrongInput"  <?= (!isset($_GET['errorLN'])) ?:"style='display: block;'"?>>
                Фамилия должна быть от 4 до 20 символов!</p>

            <input type="tel" name="mobilePhone" value="<?= $userArr["mobile_phone"] ?>"
                   pattern="[0-9]{10}" required title="Телефон должен быть 10 символов"/>
            <p class="wrongInput"  <?= (!isset($_GET['errorMN'])) ?:"style='display: block;'"?>>
                Мобильный телефон должен состоять из 10 цифр!</p>

            <input type="text" name="address" <?php if ($userArr['full_adress']) {
                echo "value=\"" . $userArr['full_adress'] . "\"";
            } else {
                echo "placeholder=\"Введите адрес доставки\"";
            } ?> pattern=".{4,200}" title="Адрес от 4 до 200 символов" ><p class="wrongInput"
                <?= (!isset($_GET['errorAR'])) ?:"style='display: block;'"?>>
                Адрес должен быть от 4 до 200 символов!</p>
            <p id='address' class="wrongInput"
                <?= (!isset($_GET['addAddress'])) ?:"style='display: block;'"?>>
                Чтобы оформлять заказы введите свой адрес для доставки!</p>
            <div id="fileupload">

                <input class="radio" type="radio" name="personal" value="1" <?php if ($userArr['is_personal'] == 1) {
                    echo "checked";
                } ?> >&nbspПерсональный&nbsp&nbsp&nbsp
                <input class="radio" type="radio" name="personal" value="2" <?php if ($userArr['is_personal'] == 2) {
                    echo "checked";
                } ?> >&nbspБизнес
            </div>

            <div id="fileupload">
                <p id="fileuploadMessage">Аватар профиля</p>
                <input type="file" name="image"/>
            </div>
            <p class="wrongInput"  <?= (!isset($_GET['errorUL'])) ?:"style='display: block;'"?>>
                Пожалуйста, загрузите фотографию до 5MB (jpg/jpeg/png/gif)</p>

            <input id="login" type="submit" value="Обновить">

            <p class="message"><a href="../main/index.php">Вернуться на главную?</a></p>
        </form>
    </div>
</div>

</body>
</html>