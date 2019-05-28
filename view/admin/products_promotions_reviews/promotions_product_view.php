<?php
require_once "../../../controller/admin/products_promotions_reviews/view_product_promotions_controller.php";
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
    <title>Админ | Скидки</title>
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../../web/assets/js/admin/remove.admin.js"></script>

</head>
<body>
<div align="center">
    <h2>Скидки для товара <?= $product['id'] ?> <?= $product['title'] ?></h2>
    <p>Здесь вы можете добавлять, редактировать и удалять скидки.</p>
    <a href="products_view.php">
        <button class="btn btn-primary">Вернуться к товарам</button>
    </a>
    <a href="promotion_create.php?pid=<?= $product['id'] ?>">
        <button class="btn btn-primary">Новая скидка для этого товара</button>
    </a>
</div>
<div class="adminMainWindow">
    <table>
        <tr>
            <th>Id</th>
            <th>Процент</th>
            <th>Дата начала</th>
            <th>Дата окончания</th>
            <th>Действия</th>
        </tr>
        <?php
        if (!empty($promotions)) {
            foreach ($promotions as $promo) {
                ?>
                <tr id="delId-<?= $promo['id'] ?>">
                    <td><?= $promo['id'] ?></td>
                    <td><?= $promo['percent'] ?></td>
                    <td><?= $promo['start_date'] ?></td>
                    <td><?= $promo['end_date'] ?></td>
                    <td>
                        <button class="btn btn-danger" onclick="deletePromo(<?= $promo['id'] ?>)">Удалить</button>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>
</body>
</html>