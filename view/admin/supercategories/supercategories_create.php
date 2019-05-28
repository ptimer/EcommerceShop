<?php

//Проверка админа
require_once '../../../utility/admin_session.php';

//Проверяем не заблокирован ли пользователь
require_once "../../../utility/blocked_user_dir_back.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Суперкатегории</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
</head>
<body>
<div class="page">
    <form action="../../../controller/admin/supercategories/new_supercategory_controller.php" method="post">
        <div class="form-group">
            <label class="control-label">Название:</label>
            <input type="text" class="form-control" name="name" placeholder="Название" maxlength="40" required>
        </div>
        <button type="submit" class="btn btn-success" name="submit">Создать</button>
    </form>
    <a href="supercategories_view.php">
        <button type="button" class="btn btn-link">Вернуться к списку суперкатегорий</button>
    </a>
</div>
</body>
</html>