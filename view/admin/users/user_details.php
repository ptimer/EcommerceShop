<?php
require_once "../../../controller/admin/users/view_user_details_controller.php";

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
    <title>Админ | Пользователи</title>
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../../web/assets/js/admin/order.manage.js"></script>
</head>
<body>
<div align="center">
    <h2>Пользователь ID <?= $userDetails['id'] ?></h2>
    <?php if ($_SESSION['role'] == 3) { ?>
        <a href="users_view.php">
            <button class="btn btn-primary">Вернуться в список пользователей</button>
        </a>
    <?php } elseif ($_SESSION['role'] == 2) { ?>
        <a href="../orders/orders_view.php">
            <button class="btn btn-primary">Вернуться в список заказов</button>
        </a>
    <?php } ?>

</div>
<div class="adminMainWindow">
    <img src="../<?= $userDetails['image_url'] ?>"><br>
    Почта: <?= $userDetails['email'] ?><br>
    Имя: <?= $userDetails['first_name'] ?><br>
    Фамилия: <?= $userDetails['last_name'] ?><br>
    <?= ($userDetails['is_personal'] == 1 ? "Личный" : "Бизнес") ?> Адрес: <?= $userDetails['full_adress'] ?><br>
    Номер телефона: <?= $userDetails['mobile_phone'] ?><br>
    Последняя активность: <?= $userDetails['last_login'] ?><br><br>
    <h3>Заказы:</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Дата создания</th>
            <th>Статус</th>
        </tr>
        <?php
        foreach ($userOrders as $order) {
            ?>
            <tr>
                <td><?= $order['id'] ?>
                    <a href="../orders/order_details.php?oid=<?= $order['id'] ?>">
                        <button class="btn btn-info">Посмотреть заказ</button>
                    </a>
                </td>
                <td><?= $order['created_at'] ?></td>
                <td><?= $order['status'] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
</body>
</html>