<?php
require_once "../../../controller/admin/sliders/view_slider_controller.php";
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
    <title>Админ | Слайдер</title>
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../../web/assets/js/admin/remove.admin.js"></script>
</head>
<body>
<div align="center">
    <h2>Слайдер</h2>
    <p>Тут вы можете добавлять новые слайды к слайдеру на главной странице.</p>
    <a href="../admin_panel.php">
        <button class="btn btn-primary">Вернуться в админ панель</button>
    </a>
    <a href="slider_create.php">
        <button class="btn btn-primary">Новый слайд</button>
    </a>
</div>
<div class="adminMainWindow">
    <table>
        <tr>
            <th>Id</th>
            <th>Заголовок</th>
            <th>Ссылка</th>
            <th>Действия</th>
        </tr>
        <?php
        foreach ($sliders as $slider) {
            ?>
            <tr>
                <td><?= $slider['id'] ?></td>
                <td><?= $slider['title'] ?></td>
                <td><?= $slider['href'] ?></td>
                <td>
                    <a href="slider_edit.php?sid=<?= $slider['id'] ?>">
                        <button class="btn btn-warning">
                            Редактировать
                        </button>
                    </a>
                    <a href="../../../controller/admin/sliders/delete_slider_controller.php?sid=<?= $slider['id'] ?>">
                        <button class="btn btn-warning">
                            Удалить
                        </button>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
</body>
</html>