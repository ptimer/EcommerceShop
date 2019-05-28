<?php
require_once "../../../controller/admin/subcategory_specs/new_subcat_spec_controller.php";

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
    <title>Характеристики</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
</head>
<body>
<div class="page">
    <form action="../../../controller/admin/subcategory_specs/new_subcat_spec_controller.php" method="post">

        <div class="form-group">
            <label class="control-label">Название:</label>
            <input class="form-control"type="text" name="name" placeholder="Название" maxlength="40"
               required>
        </div>


        <div class="form-group">
            <label for="exampleFormControlSelect1">Выберите подкатегорию</label>
            <select class="form-control" name="subcategory_id" id="selectSubCatId" required>
                  <?php
                    foreach ($subcategories as $subcategory) {
                        echo "<option value=\"" . $subcategory['id'] . "\">" . $subcategory['name'] . "</option>";
                    }
                   ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success" name="submit">Создать</button>
    </form>
    <a href="subcat_specs_view.php">
        <button type="button" class="btn btn-link">Вернуться к списку характеристик</button>
    </a>
</div>
</body>
</html>
