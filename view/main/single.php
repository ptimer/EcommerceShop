<?php
//Контроллер для вывода товара
require_once "../../controller/products/single_product_controller.php";
//Include controller for checking if product is in favourites and if user is logged
require_once "../../controller/favourites/check_favourites_controller.php";
//Стили и скрипты
require_once "../elements/headers.php";
?>

    <!-- CSS for Flex Slider -->
    <link rel="stylesheet" href="../../web/assets/css/flexSliderJQuery.css" type="text/css" media="screen"/>
    <!-- CSS for Simple Slider  -->
    <link rel="stylesheet" href="../../web/assets/css/simplerSliderW3.css">
    <!-- CSS for replacing Flex Slider with Normal Slider -->
    <link rel="stylesheet" href="../../web/assets/css/replaceFlexNormalSlider.css">
    <!-- CSS for reviews -->
    <link rel="stylesheet" href="../../web/assets/css/reviews.css" type="text/css"/>
    <!-- CSS for accordion -->
    <link rel="stylesheet" href="../../web/assets/css/accordion.css" type="text/css"/>

    <!-- Script for adding product to favourites -->
    <script type="text/javascript" src="../../web/assets/js/favourites.js"></script>
    <!-- Flex Slider JQuery -->
    <script type="text/javascript" defer src="../../web/assets/js/jquery.flexslider.js"></script>
    <!-- Image Zoom JS -->
    <script type="text/javascript" src="../../web/assets/js/image.zoom.js"></script>
    <!-- Deleting Review with AJAX JS -->
    <script type="text/javascript" src="../../web/assets/js/delReview.js"></script>

    <title>lGG'sP | <?= $product['title'] ?></title>


<?php
//Хедер
require_once "../elements/header.php";
//Навигация
require_once "../elements/navigation.php";
?>

    <!-- Товар -->
    <div class="products">
        <div class="container">
            <div class="products-grids">
                <div class="col-md-8 products-single">

                    <!-- Простой слайдер, display: none по умолчанию-->
                    <div id="normalSlider" class="col-md-5 grid-single">
                        <div class="flexslider">
                            <ul class="slides">
                                <div class="w3-content">
                                    <img class="mySlides" src="<?= $images[0]['image_url'] ?>">
                                    <img class="mySlides" src="<?= $images[1]['image_url'] ?>">
                                    <img class="mySlides" src="<?= $images[2]['image_url'] ?>">

                                    <div class="w3-row-padding w3-section">
                                        <div class="w3-col s4">
                                            <img class="demo w3-opacity w3-hover-opacity-off "
                                                 src="<?= $images[0]['image_url'] ?>"
                                                 onclick="currentDiv(1)">
                                        </div>
                                        <div class="w3-col s4">
                                            <img class="demo w3-opacity w3-hover-opacity-off"
                                                 src="<?= $images[1]['image_url'] ?>"
                                                 onclick="currentDiv(2)">
                                        </div>
                                        <div class="w3-col s4">
                                            <img class="demo w3-opacity w3-hover-opacity-off"
                                                 src="<?= $images[2]['image_url'] ?>"
                                                 onclick="currentDiv(3)">
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>

                    <!-- JS for Simple Slider -->
                    <script src="../../web/assets/js/simple.slider.w3.js"></script>

                    <!-- Flex Slider -->
                    <div id="flexSliderDiv" class="col-md-5 grid-single">
                        <div class="flexslider">
                            <ul class="slides">
                                <?php foreach ($images as $image) { ?>
                                    <li data-thumb="<?= $image['image_url'] ?>">
                                        <div class="thumb-image">
                                            <img src="<?= $image['image_url'] ?>" data-imagezoom="true"
                                                 class="img-responsive" alt=""/>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Информация о товаре -->
                    <div class="col-md-7 single-text">
                        <h3><?= $product['title']; ?></h3>
                        <p class="availability"><span class="color">
                                <?php if ($product['quantity'] == 0) {
                                    echo "Нет в наличии";
                                } else {echo "Есть в наличии"; } ?></span></p>
                        <div class="price_single">
                            <?php
                            if ($promotedPrice !== null) {
                                ?>
                                <span class="reducedfrom"><?= $product['price']; ?> грн</span>
                                <span class="actual item_price"><?= $promotedPrice; ?> грн</span>
                                <?php
                            } else {
                                ?>
                                <span class="actual item_price"><?= $product['price']; ?> грн</span>
                                <?php
                            }
                            ?>
                        </div>
                        <img id="averageRating" class="media-object img"
                             src="../../web/assets/images/rating<?= $product['average'] ?>.png"><br/>
                        <div class="clearfix"></div>

                        <!-- Кнопки для добавления в корзину, закладки, отзывов -->
                        <span id="quantityTextSingle" class="label label-default">Количество:</span>
                        <select id="buyQuantity" class="form-control">
                            <?php for ($i = 1; $i <= 50; $i++) {
                                echo "<option value=\"$i\">$i</option>";
                            } ?>
                        </select>
                        <button id='addCartButtonSingle' type="submit" class="btn btn-default"
                                onclick="addToCartSingle(<?= $product['id'] . "," .
                                (isset($promotedPrice) ? $promotedPrice : $product['price']) ?>)"><span
                                    class="glyphicon glyphicon-shopping-cart"></span> Добавить в корзину
                        </button>
                        <br/>
                        <?php if (!($isFavourite == 3)) {
                            if ($isFavourite == 2) { ?>
                                <div id="favourite">
                                    <button style="display: inline-block;" class="btn btn-primary"
                                            onclick="addFavourite(<?= $product['id'] ?>)"><span
                                                class="glyphicon glyphicon-heart"></span> Добавить в закладки
                                    </button>
                                </div>
                            <?php } else { ?>
                                <div id="favourite">
                                    <button style="display: inline-block;" class="btn btn-danger"
                                            onclick="removeFavourite(<?= $product['id'] ?>)"><span
                                                class="glyphicon glyphicon-heart-empty"></span> Удалить с закладок
                                    </button>
                                </div>
                            <?php }
                        }
                        if (isset($_SESSION['loggedUser'])) { ?>
                            <br/>
                            <a href="review.php?pid=<?= $product['id'] ?>" style="display: inline-block;"
                               class="btn btn-primary btn-warning">
                                <span class="glyphicon glyphicon-tag"></span> Оставить отзыв</a>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>


                <!-- Подробная информация о товаре -->
                <div class="panel-group collpse" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" aria-controls="collapseOne">
                                    Описание
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                             aria-labelledby="headingOne">
                            <div class="panel-body">
                                <?= $product['description']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Характеристики
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <table>
                                    <?php
                                    foreach ($specifications as $spec) {
                                        ?>
                                        <tr>
                                            <td><?= $spec['name']; ?></td>
                                            <td><?= $spec['value']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Отзывы(<?= $reviewsCount ?>)
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingThree">

                            <?php foreach ($reviews as $review) { ?>
                                <div id="rev-<?= $review['id'] ?>">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="comments-logout">
                                            <ul class="media-list">
                                                <li class="media">

                                                    <div class="pull-left" href="#">
                                                        <img class="media-object img-circle"
                                                             src="<?= $review['image_url'] ?>"
                                                             alt="profile">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="well well-lg">
                                                            <h4 class="media-heading text-uppercase reviews">
                                                                <?= $review['title'] . "<small>" . "&nbsp by " .
                                                                $review['first_name'] . "</small>" ?>
                                                                <img id="reviewRating" class="media-object img"
                                                                     src="../../web/assets/images/rating<?=
                                                                     $review['rating'] ?>.png">
                                                            </h4>
                                                            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 3
                                                                    || $_SESSION['role'] == 2)
                                                            ) { ?>
                                                                <div onclick="delReview(<?= $review['id'] ?>)"
                                                                     class="close1"
                                                                ></div> <?php } ?>
                                                            <ul class="media-date text-uppercase reviews list-inline">
                                                                <li class="dd"> <?= $review['created_at'] ?></li>

                                                            </ul>
                                                            <p class="media-comment" id="reviewComment">
                                                                <?= $review['comment'] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Рекомендуемые товары -->
                <div class="collection-section">
                    <?php if (count($relatedProducts)) {
                        echo "<h3 class=\"title\">Рекомендуемые товары</h3>";
                    } ?>
                    <div class="main_filtered_product-info">
                        <?php foreach ($relatedProducts as $product) {
                            if ($product['percent'] != null) {
                                $promotedPrice = round($product['price'] - (($product['price'] *
                                            $product['percent']) / 100), 2);
                            } else {
                                unset($promotedPrice);
                            } ?>
                            <div class="products-grd" id='responsiveProductsDiv'>
                                <div class="p-one">
                                    <a href="single.php?pid=<?= $product['id']; ?>">
                                        <img src="<?= $product['image_url'] ?>"
                                             alt="Product Image" class="img-responsive"/></a>
                                    <p style="margin: 1em 0 0.5em 0;color: #5e97ff;font-size: 1em;"><?= $product['title']; ?></p>
                                    <!-- Отзывы. Если average = null, тогда присваиваем 0, чтобы потом подключить картинку и так со всеми номерами до 5-->
                                    <?php if ($product['average'] === null) {
                                        $product['average'] = 0;
                                    } else {
                                        $product['average'] = round($product['average'], 0);
                                    } ?>

                                    <img class="ratingCatDiv media-object img"
                                         src="../../web/assets/images/rating<?= $product['average'] ?>.png">
                                    <span>(<?= $product['reviewsCount'] ?>)</span>
                                    <br/><br/>
                                    <!-- -->
                                    <p>
                                        <?php
                                        if (isset($promotedPrice)) {
                                            ?>
                                            <span class="item_price valsa"
                                                  style="color: red;"><?= $promotedPrice; ?> грн</span>
                                            <span class="item_price promoValsa"><?= $product['price']; ?> грн</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="item_price valsa"><?= $product['price']; ?> грн</span>
                                            <?php
                                        }
                                        ?><br>
                                        <a id="addButtonBlock" class="btn btn-default btn-sm"
                                          onclick="addToCart(<?= $product['id'] . "," . $product['price'] ?>)">
                                            <i class="glyphicon glyphicon-shopping-cart"></i>&nbspДобавить в корзину
                                        </a>&nbsp&nbsp
                                        </p><br/>
                                    <div class="pro-grd">
                                        <a href="single.php?pid=<?= $product['id']; ?>">Купить</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//Футер
require_once "../elements/footer.php";
?>