<?php
require_once "../../../controller/admin/subcategories/edit_subcategory_controller.php";

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
    <title>Редактировать подкатегорию</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
</head>
<body>
<div class="page">
    <form action="../../../controller/admin/subcategories/edit_subcategory_controller.php" method="post">
        <input type="hidden" name="subcat_id" value="<?= $subcat['id'] ?>">

        <div class="form-group">
            <label class="control-label">Название подкатегории:</label>
            <input class="form-control"type="text" name="name" placeholder="Название подкатегории" value="<?= $subcat['name'] ?>" maxlength="40"
               required>
        </div>


        <div class="form-group">
            <label for="exampleFormControlSelect1">Выберите категорию</label>
            <select class="form-control" name="category_id" required>
                  <?php
                    foreach ($categories as $category) {
                        echo "<option value=\"" . $category['id'] . "\"";
                        if ($category['id'] == $subcat['category_id']) {
                            echo "Выбрана";
                        }
                        echo ">" . $category['name'] . "</option>";
                    }
                   ?>
            </select>
        </div>


       <button type="submit" class="btn btn-success" name="submit">Редактировать</button>
    </form>
    <a href="subcategories_view.php">
        <button type="button" class="btn btn-link">Вернуться к списку подкатегорий</button>
    </a>
</div>
</body>
</html>
