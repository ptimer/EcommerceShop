<?php
//Подключаем контроллер для меню
require_once "../../controller/navigation/navigation_controller.php";
//Подключаем контроллер для кнопки корзины и информации с количеством товаров и общей цены
require_once "../../controller/cart/cart_navi_controller.php"
?>

<!-- Хедер -->
<div id="header_bg">
    <div class="container">
        

        <div class="container" style="margin-top: 45px;margin-bottom: 25px">
            <div class="row">
                <div class="col-md-3">
                    <a href="index.php">
                        <img src="../../web/assets/images/logo.png">
                    </a>
                </div>
                <div class="col-md-3" style="margin-bottom: 20px">
                     <small >Call Center</small>
                     <div style="font-size: 20px; color: black">
                        0(800) 33-41-45
                    </div>
                    <div style="color: #3e77aa">
                        БЕСПЛАТНО С МОБИЛЬНЫХ
                    </div>
                    <div style="color: #3e77aa">
                        (063) 587-28-80
                    </div>
                    <div style="color: #3e77aa">
                        (096) 757-58-32
                    </div>
                    <div style="color: #3e77aa">
                        (095) 636-04-06
                    </div>
                </div>
                <div class="col-md-3" style="margin-bottom: 20px">
                    <div style="color: #3e77aa">
                        Киев, ул. Ивана Франко 42
                    </div>
                    <div style="color: #3e77aa">
                        М.Университет
                    </div>
                    <div style="color: #3e77aa">
                        М. Золотые ворота
                    </div>
                    <div style="color: #3e77aa">
                        Пн - Вс - 10:00 - 21:00
                    </div>
                </div>
                <div class="col-md-3" >
                        <div class="row">
                             <div class="col-md-4">
                                  
                             </div>
                                <div class="col-md-8" style="margin-top: 45px;">
                                <!-- Кнопка корзины -->
                                    <div id="cartToHover" class="cart box_1 ">
                                            <a href="checkout.php">
                                                <div class="total">
                                                    <div id="cartTotalPrice"><?= $cartTotalPrice ?></div> грн
                                                    <br>(
                                                    <div id="cartItems"><?= $cartItems ?></div>
                                                    товаров )
                                                </div>
                                                <i class="glyphicon glyphicon-shopping-cart" style="font-size: 30px; top: 10px"></i></a>

                                            <div class="clearfix"></div>
                                    </div>
                                    <div id="cartDivHover" style="margin-top: 60px"></div>
                                <?php if (isset($_SESSION['loggedUser'])) { ?>
                                <a href="../main/favourites.php">
                                        <button class="btn btn-primary btn-info" style="margin-left: 40px;" id='favouritesButton'><span
                                                    class="glyphicon glyphicon-heart"></span> Закладки
                                        </button>
                                    </a>&nbsp&nbsp&nbsp&nbsp
                                <?php } else { ?>
                                    <div class="btn btn-primary btn-info"  style="margin-left: 40px;" id='invisible'><span
                                                class="glyphicon glyphicon-heart"></span>
                                    </div>&nbsp&nbsp&nbsp&nbsp
                                <?php } ?>
                            </div>
                        </div>

                    
                </div>
            </div>
        </div>

        <!-- Панель навигации (с категориями), которые передаются с контроллера -->
        <ul class="megamenu skyblue">
            <?php foreach ($supercategories as $supercategory) { ?>
                <li class="grid"><a class="color2" href="#"><?= $supercategory["name"] ?></a>
                    <div class="megapanel">
                        <div class="row">
                            <?php foreach ($categories as $category) {
                                if ($category['supercategory_id'] == $supercategory['id']) { ?>
                                    <div class="col1">
                                        <div class="h_nav">
                                            <h4><?= $category["name"] ?></h4>
                                            <ul>
                                                <?php foreach ($subcategories as $subcategory) {
                                                    if ($subcategory['category_id'] == $category['id']) { ?>
                                                        <li>
                                                            <a href="product.php?subcid=<?= $subcategory["id"] ?>">
                                                                <?= $subcategory["name"] ?></a>
                                                        </li>
                                                    <?php }
                                                } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                        <div class="row">
                            <div class="col2"></div>
                            <div class="col1"></div>
                            <div class="col1"></div>
                            <div class="col1"></div>
                            <div class="col1"></div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>