<?php
//Include Admin check
require_once '../../../utility/admin_mod_session.php';
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
    <title>Создать скидку</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">
</head>
<body>
<div class="page">
    <form action="../../../controller/admin/products_promotions_reviews/new_product_promotion_controller.php"
          method="post">

        <div class="form-group">
            <label class="control-label">Процент:</label>
            <input type="number" class="form-control" name="percent" placeholder="%" required>
        </div>

        <div class="form-group">
            <label class="control-label">Дата начала:</label>
            <input  class="form-control" type="datetime-local" name="start_date" placeholder="Дата начала" required>
        </div>

        <div class="form-group">
            <label class="control-label">Дата окончания:</label>
            <input  class="form-control" type="datetime-local" name="end_date" placeholder="Дата окончания" required>
        </div>

        <input type="hidden" name="product_id" value="<?= $_GET['pid'] ?>">

        <button type="submit" class="btn btn-success" name="submit">Добавить скидку!</button>
    </form>
    <a href="products_view.php">
        <button type="button" class="btn btn-link">Вернуться к списку товаров</button>
    </a>
</div>
</body>
</html>