<?php
require_once "../../../controller/admin/categories/new_category_controller.php";

//Проверяем не заблокирован ли юзер
require_once "../../../utility/blocked_user_dir_back.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
</head>
<body>
<div class="page">
    <form action="../../../controller/admin/categories/new_category_controller.php" method="post">
        <div class="form-group">
            <label for="recipient-name" class="control-label">Название категории:</label>
            <input type="text" class="form-control" id="recipient-name" name="name" placeholder="Название категории" maxlength="40"   required>
          </div>
        <div class="form-group">
        <label for="exampleFormControlSelect1">Выберите суперкатегорию</label>
        <select class="form-control" name="supercategory_id" id="exampleFormControlSelect1" required>
          <?php
            foreach ($supercategories as $supercategory) {
                echo "<option value=\"" . $supercategory['id'] . "\">" . $supercategory['name'] . "</option>";
            }
            ?>
        </select>
      </div>
        <button type="submit" class="btn btn-success" name="submit">Создать</button>
    </form>
    <a href="categories_view.php">
        <button type="button" class="btn btn-link">Назад в категории</button>
    </a>
</div>
</body>
</html>
