<?php
require_once "../../../controller/admin/supercategories/edit_supercategory_controller.php";

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
    <title>Редактировать суперкатегорию</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
</head>
<body>
<div class="page">
    <form action="../../../controller/admin/supercategories/edit_supercategory_controller.php" method="post">
        <input type="hidden" name="supercat_id" value="<?= $superCat['id'] ?>">
         <div class="form-group">
            <label class="control-label">Название:</label>
            <input class="form-control"type="text" name="name" placeholder="название суперкатегории" value="<?= $superCat['name'] ?>" maxlength="40"
               required>
        </div>
        <button type="submit" class="btn btn-success" name="submit">Редактировать</button>
    </form>
    <a href="supercategories_view.php">
        <button type="button" class="btn btn-link">Вернуться к списку суперкатегорий</button>
    </a>
</div>
</body>
</html>
