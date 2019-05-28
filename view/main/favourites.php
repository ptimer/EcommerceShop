<?php
//Подключаем контроллер для закладок юзера
require_once "../../controller/favourites/all_favourites_user_controller.php";
//Подключаем стили и скрипты
require_once "../elements/headers.php";
?>

    <!--Скрипт для удаления из закладок -->
    <script type="text/javascript" src="../../web/assets/js/favourites.js"></script>

    <title>lGG'sP | Закладки</title>

<?php
//Подключаем хедер
require_once "../elements/header.php";
//Подключаем навигацию
require_once "../elements/navigation.php";
?>

    <!-- Выводим закладки -->
    <div class="cart-items">
        <div class="container">
            <h3 id='favouritesTitle' class="title">
                <?= (count($products) ? "Мои закладки" : "Вы не добавили никаких товаров") ?> </h3>

            <?php foreach ($products as $product) { ?>
                <div id="deleteItem<?= $product['id'] ?>">
                    <div class="cart-header">
                        <div class="close1" onclick="removeFavouriteList(<?= $product['id'] ?>)"></div>
                        <div class="cart-sec simpleCart_shelfItem">
                            <div class="cart-item cyc">
                                <a href="single.php?pid=<?= $product['id'] ?>">
                                    <img src="<?= $product['image_url'] ?>" class="img-responsive" alt=""></a>
                            </div>
                            <div class="cart-item-info">
                                <h3><a href="single.php?pid=<?= $product['id'] ?>"> <?= $product['title'] ?> </a></h3>
                                <div class="delivery">
                                    <p><?= $product['price'] ?> грн</p>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

<?php
//Подключаем футер
require_once "../elements/footer.php";
?>