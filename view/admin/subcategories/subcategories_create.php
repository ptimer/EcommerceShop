<?php
require_once "../../../controller/admin/subcategories/new_subcategory_controller.php";

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
    <title>Создать подкатегорию</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
</head>
<body>
<div class="page">
    <form action="../../../controller/admin/subcategories/new_subcategory_controller.php" method="post">
        
        <div class="form-group">
            <label class="control-label">Название подкатегории:</label>
            <input class="form-control"type="text" name="name" placeholder="Название подкатегории" maxlength="40"
               required>
        </div>


        <div class="form-group">
            <label for="exampleFormControlSelect1">Выберите категорию</label>
            <select class="form-control" name="category_id" required>
                  <?php
                    foreach ($categories as $category) {
                        echo "<option value=\"" . $category['id'] . "\">" . $category['name'] . "</option>";
                    }
                ?>
            </select>
        </div>



        <button type="submit" class="btn btn-success" name="submit">Создать</button>
    </form>
    <a href="subcategories_view.php">
        <button type="button" class="btn btn-link">Вернуться к списку подкатегорий</button>
    </a>
</div>
</body>
</html>
