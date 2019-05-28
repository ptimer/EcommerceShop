<?php
require_once "../../../controller/admin/subcategory_specs/view_subcat_specs_controller.php";
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
    <title>Админ | Характеристики</title>
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../../web/assets/js/admin/remove.admin.js"></script>
</head>
<body>
<div align="center">
    <h2>Характеристики подкатегории</h2>
    <p>Здесь вы можете создавать, удалять и редактировать характеристики подкатегории.</p>
    <a href="../admin_panel.php">
        <button class="btn btn-primary">Вернуться в админ панель</button>
    </a>
    <a href="subcat_spec_create.php">
        <button class="btn btn-primary">Новая характеристика</button>
    </a>
</div>
<div class="adminMainWindow">
    <table>
        <tr>
            <th>Id</th>
            <th>Название</th>
            <th>Подкатегория</th>
            <th>Действия</th>
        </tr>
        <?php
        foreach ($specs as $spec) {
            ?>
            <tr id="delId-<?= $spec['id'] ?>">
                <td><?= $spec['id'] ?></td>
                <td><?= $spec['name'] ?></td>
                <td><?= $spec['subcat_name'] ?></td>
                <td>
                    <a href="subcat_spec_edit.php?ssid=<?= $spec['id'] ?>">
                        <button class="btn btn-warning">
                            Редактировать
                        </button>
                    </a>
                    <button class="btn btn-danger" onclick="deleteSpec(<?= $spec['id'] ?>)">Удалить</button>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
</body>
</html>