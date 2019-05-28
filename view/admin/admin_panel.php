<?php

// Сессия
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Авторизован ли пользователь ?
if (!isset($_SESSION['role']) || $_SESSION['role'] == 1) {

    //Ошибка
    header("Location: ../../view/error/error_400.php");
    die();
}

//Проверяем на блокировку
require_once "../../utility/blocked_user.php";

require_once "../elements/headers.php";
?>
<meta charset="UTF-8">
<title>Админ панель</title>
<link rel="stylesheet" href="../../web/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../../web/assets/css/adminPanel.css">
<link rel="stylesheet" href="../../web/assets/css/font-awesome.min.css">
</head>
<?php
require_once "../elements/header.php";
?>
<body>
<br><br><br><br>
<a href="../main/index.php">
    <button class="btn btn-primary">Вернуться на сайт</button>
</a>
<div align="center">
    <h3>Добро пожаловать ! Что бы вы хотели сделать ?</h3>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 3) { ?>
    <a href="supercategories/supercategories_view.php">
        <button class="btn btn-sq-lg btn-primary"><i class="fa fa-th-large fa-4x" aria-hidden="true"></i><br>Супер<br>категории
        </button>
    </a>
    <a href="categories/categories_view.php">
        <button class="btn btn-sq-lg btn-primary"><i class="fa fa-th fa-4x" aria-hidden="true"></i><br>Категории
        </button>
    </a>
    <a href="subcategories/subcategories_view.php">
        <button class="btn btn-sq-lg btn-primary"><i class="fa fa-th-list fa-4x" aria-hidden="true"></i><br>Подкатегории
        </button>
    </a>
    <a href="subcategory_specs/subcat_specs_view.php">
        <button class="btn btn-sq-lg btn-primary"><i class="fa fa-info fa-4x" aria-hidden="true"></i><br>Характеристики<br>товаров
        </button>
    </a><br>
    <?php } ?>
    <a href="products_promotions_reviews/products_view.php">
        <button class="btn btn-sq-lg btn-primary"><i class="fa fa-cubes fa-4x" aria-hidden="true"></i><br>Товары
        </button>
    </a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 3) { ?>
    <a href="users/users_view.php">
        <button class="btn btn-sq-lg btn-primary"><i class="fa fa-user fa-4x" aria-hidden="true"></i><br>Пользователи</button>
    </a>
    <?php } ?>
    <a href="orders/orders_view.php">
        <button class="btn btn-sq-lg btn-primary"><i class="fa fa-plane fa-4x" aria-hidden="true"></i><br>Заказы
        </button>
    </a><br>
    <a href="sliders/slider_view.php">
        <button class="btn btn-sq-lg btn-primary"><i class="fa fa-television fa-4x" aria-hidden="true"></i><br>Слайдер
        </button>
    </a>
</div>
</body>
</html>