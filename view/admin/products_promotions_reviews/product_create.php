<?php
require_once "../../../controller/admin/products_promotions_reviews/new_product_controller.php";

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
    <title>Создать товар</title>
    <link rel="stylesheet" href="../../../web/assets/css/adminPanel.css">
    <link rel="shortcut icon" href="../../../web/assets/images/favicon.ico?v4" type="image/x-icon">
    <script src="../../../web/assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../../web/assets/js/admin/product.specs.js"></script>
    <link rel="stylesheet" href="../../../web/assets/css/bootstrap.min.css">

</head>
<body>
<div class="page">
    <form enctype="multipart/form-data"
          action="../../../controller/admin/products_promotions_reviews/new_product_controller.php" method="post">
        <div class="form-group">
            <label class="control-label">Заголовок:</label>
            <input type="text" class="form-control" id="recipient-name" name="title" placeholder="Заголовок" maxlength="40" required>
        </div>


        <div class="form-group">
            <label for="exampleFormControlTextarea1">Описание</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
            name="description" placeholder="Описание" maxlength="150000" required
            ></textarea>
        </div>

        <div class="form-group">
            <label class="control-label">Цена:</label>
            <input type="number" name="price" step="0.01" placeholder="Цена" min="0" maxlength="100000000"
                     required class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">Количество:</label>
            <input type="number" name="quantity" step="0.01" placeholder="Количество" min="0" maxlength="100000000"
                     required class="form-control">
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Изображения</label>
            <input type="file" class="form-control-file" name="pic1" required>
            <input type="file" class="form-control-file" name="pic2" required>
            <input type="file" class="form-control-file" name="pic3" required>
        </div>
        

        <div class="form-group">
            <label for="exampleFormControlSelect1">Выберите подкатегорию</label>
            <select class="form-control" name="subcategory_id" id="selectSubCatId" onchange="loadSpecs()" required>
              <?php
                foreach ($subcategories as $subcategory) {
                    ?>
                    <option value="<?= $subcategory['id'] ?>"> <?= $subcategory['name'] ?> </option>
                    <?php
                }
               ?>
            </select>
        </div>

        
        <div id="specsWindow">
            
        </div>

        <button type="submit" class="btn btn-success" name="submit">Создать товар</button>
    </form>
    <a href="products_view.php">
        <button type="button" class="btn btn-link">Вернуться к списку товаров</button>
    </a>
</div>
</body>
</html>
