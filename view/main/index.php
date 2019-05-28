<?php
// Подключаем контроллер
require_once "../../controller/products/home_products_controller.php";
// Подключаем head со скриптами и стилями
require_once "../elements/headers.php";
?>

    <title>lGG'sP | Главная</title>

<?php
// Подключаем хедер
require_once "../elements/header.php";
// Подключаем навигацию
require_once "../elements/navigation.php";
?>
    
    <div class="container">
        <div class="row">
             <div id="carousel-example-generic" class="carousel slide center-block" data-ride="carousel" style="margin-top: 20px">
              <ol class="carousel-indicators">
                <?php foreach($slides as $key => $slide){ ?>
                  <li style="background: #5e97ff" data-target="#carousel-example-generic" data-slide-to="<?=$key?>" class="<?php if($key == 0){echo 'active';}?>"></li>
                <?php } ?>
              </ol>
              <div class="carousel-inner" role="listbox">
                <?php foreach($slides as $key => $slide){ ?>
                  <div class="<?php if($key == 0){echo 'item active';}else{echo 'item';} ?>">
                     <a target="_blank" href="<?=$slide['href']?>"><img src="<?=$slide['image_url'] ?>" alt="..." class="center-block"></a>
                     <div class="carousel-caption"></div>
                  </div>
                  
                <?php } ?>
              </div>
               <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
        </div>
    </div>

    <!-- Выводим список всех товаров $products -->
    <div class="main_filtered_products-section">
        <div class="container">
            <h3 class="title">Доступные товары</h3>
            <div class="main_filtered_product-info">

                <?php foreach ($products as $product) {
                     ?>
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
                                <span class="item_price valsa"><?= $product['price']; ?> грн</span><br>
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

<?php
//Подключаем футер
require_once "../elements/footer.php";
?>