<?php
require_once "../../../controller/admin/sliders/edit_slider_controller.php";

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
    <title>Редактировать слайдер</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../../web/assets/js/admin/product.specs.js"></script>
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">

</head>
<body>
<div class="page">
    <form enctype="multipart/form-data"
          action="../../../controller/admin/sliders/edit_slider_controller.php" method="post">
        <input type="hidden" name="sid" value="<?= $_GET['sid'] ?>">

        <div class="form-group">
            <label class="control-label">Заголовок:</label>
            <input type="text" class="form-control" name="title" placeholder="Заголовок" maxlength="500" required>
        </div>


        <div class="form-group">
            <label class="control-label">Ссылка:</label>
            <input type="text" class="form-control" name="href" placeholder="Ссылка" maxlength="500" required>
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Изображение</label>
            <input type="file" class="form-control-file" name="pic1">
        </div>

        <button type="submit" class="btn btn-success" name="submit">Редактировать слайдер</button>
    </form>
    <a href="slider_view.php">
        <button type="button" class="btn btn-link">Вернуться к списку слайдов</button>
    </a>
</div>
</body>
</html>
