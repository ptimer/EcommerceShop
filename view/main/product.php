<?php
require_once "../../controller/products/products_by_category_controller.php";
//Подключаем скрипты и стили
require_once "../elements/headers.php";
?>
    <title>lGG'sP | <?= $subcatName ?></title>

    <!-- Price Slider CSS and JS -->
    <link rel="stylesheet" href="../../web/assets/css/jquery-ui.css">
    <script src="../../web/assets/js/jquery-ui.js"></script>
    <!-- Подгрузка товаров по фильтру -->
    <script src="../../web/assets/js/products/products.by.category.js"></script>


<?php
//Хедер
require_once "../elements/header.php";
//Навигация
require_once "../elements/navigation.php";
?>

    <!-- Продукты за категорией -->
    <div class="products">
        <div class="container">
            <div class="products-grids">
                <div class="col-md-4 products-grid-right">
                    <div class="w_sidebar">
                        <div class="w_nav1">
                            <h4>Параметры</h4>
                            Порядок по:
                            <select class="form-control" id="filter" onchange="filteredProducts()">
                                <option value="1" selected>Самым новым</option>
                                <option value="2">Самым продаваемым</option>
                                <option value="3">С высоким рейтингом</option>
                            </select>
                        </div>
                        <section class="sky-form">
                            <h4>Цена</h4>
                            <p>
                                <label for="amount">:</label>
                                <input type="text" id="amount" readonly
                                       style="border:0; color:#f6931f; font-weight:bold;">
                            </p>

                            <div id="slider-range"></div>
                        </section>
                    </div>
                </div>
                <h2><?=$subcatName?></h2>
                <div class="col-md-8 products-grid-left" id="productsWindow">
                </div>
                <div id="loader" style="display: block" class="center-block"></div>
            </div>
        </div>
    </div>

<?php
//Подключить футер
require_once "../elements/footer.php";
?>