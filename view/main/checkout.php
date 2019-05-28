<?php
//Контроллер для показа товаров в корзине
require_once "../../controller/cart/show_cart_controller.php";
//Скрипты и стили
require_once "../elements/headers.php";
?>

    <!-- CSS  -->
    <link rel="stylesheet" href="../../web/assets/css/cart.css">

    <!-- Script для удаления товара с корзины -->
    <script type="text/javascript" src="../../web/assets/js/cart/remove.cart.js"></script>

    <!-- Script для контроля количества товара -->
    <script type="text/javascript" src="../../web/assets/js/cart/quantity.cart.js"></script>

    <title>lGG'sP | Корзина</title>

<?php
//Хедер
require_once "../elements/header.php";
//Навигация
require_once "../elements/navigation.php";
?>

    <!-- Выводим общую сумму заказа и заказать -->
    <div class="cart-items">
        <div class="container">
            <h3 class="title">Мои товары(
                <div id="cartItems2"><?= ($orderSuccessful === 1 ? $orderQuantity : $cartItems) ?></div>
                )
            </h3>
            <br>
            <h3 class="b-tittle" id='totalPrice'>Общая цена:
                <div id="totalPriceCurrency">
                    <div id="cartTotalPrice2">
                        <?= ($orderSuccessful === 1 ? $orderTotalPrice : $cartTotalPrice) ?></div>Грн
                </div>
            </h3>
            <br>
            <?php
            if ($cartIsEmpty === 0) {

            if (!empty($_SESSION['loggedUser'])) {
                ?>
                <a href="../../controller/cart/new_order_controller.php">
                    <button class="btn btn-danger btn-lg btn-block" id="checkOutButton">Заказать</button>
                </a>
            <?php } else { ?>
                <a href="../../view/user/login.php">
                    <button class="btn btn-danger btn-lg btn-block" id="checkOutButton">Войти, чтобы оформить заказ</button>
                </a> <?php } ?>
                <!-- Выводим товары в корзину -->
                <?php foreach ($cart as $cartProduct) { ?>
                    <div id="product-<?= $cartProduct->getId() ?>">
                        <div class="cart-header">
                            <div id="button-<?= $cartProduct->getId() ?>" class="close1"
                                 onclick="removeFromCart(<?= $cartProduct->getId() .
                                 "," . $cartProduct->getPrice() ?>)"></div>
                            <div class="cart-sec simpleCart_shelfItem">
                                <div class="cart-item cyc">
                                    <a href="single.php?pid=<?= $cartProduct->getId() ?>"><img
                                                src="<?= $cartProduct->getImage() ?>" class="img-responsive" alt="">
                                    </a></div>
                                <div class="cart-item-info">
                                    <h3>
                                        <a href="single.php?pid=<?= $cartProduct->getId() ?>">
                                            <?= $cartProduct->getTitle() ?>
                                        </a>
                                    </h3>
                                    <p>
                                    <div id="quantityText">Количество:<span id="quantityNumber">
                                            <span id="product-<?= $cartProduct->getId() ?>-quantity">
                                        <?= $cartProduct->getQuantity() ?>
                                    </span></span></div>
                                        <button class="btn btn-xs btn-info glyphicon glyphicon-minus"
                                                onclick="removeOneQuantityFromCart
                                                (<?= $cartProduct->getId()
                                        . "," . $cartProduct->getPrice() ?>)"></button>

                                    <button class="btn btn-xs btn-info glyphicon glyphicon-plus"
                                            onclick="addOneQuantityToCart
                                            (<?= $cartProduct->getId()
                                    . "," . $cartProduct->getPrice() ?>)"></button>
                                    </p>
                                    <div class="delivery">
                                        <p> 
                                        <div id="product-<?= $cartProduct->getId() ?>-totalPrice">
                                            <?= $cartProduct->getPrice() * $cartProduct->getQuantity() ?> грн
                                        </div>
                                        </p><br>
                                        <p>Цена: <?= $cartProduct->getPrice() ?> грн</p>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                <?php }
            } elseif ($cartIsEmpty === 1 && $orderSuccessful === 0) { ?>
                <h3 align="center">Корзина пуста!</h3><br>
                <?php
            } elseif ($orderSuccessful === 1) {
                ?>
                <h3 align="center">Ваш заказ прошел успешно! Номер заказа <?= $orderNumber ?>.
                    Ожидайте звонка от нас на протяжении 24 часов :)</h3><br>
                <?php
            }
            ?>
            <a href="index.php">
                <button class="btn btn-success btn-lg btn-block">Вернуться к покупкам</button>
            </a>
        </div>
    </div>

<?php
//Футер
require_once "../elements/footer.php";
?>