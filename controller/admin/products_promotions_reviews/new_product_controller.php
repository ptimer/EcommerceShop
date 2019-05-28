<?php

session_start();


require_once '../../../utility/error_handler_dir_back.php';


require_once '../../../utility/admin_mod_session.php';


require_once '../../../utility/imageCrop.php';

//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}


if (isset($_POST['submit'])) {
    $product = new \model\Product();


    $product->setTitle(htmlentities($_POST['title']));
    $product->setDescription(htmlentities($_POST['description']));
    $product->setPrice(htmlentities($_POST['price']));
    $product->setQuantity(htmlentities($_POST['quantity']));

    //Валидация
    if (strlen($_POST['title']) > 300 ||
        strlen($_POST['description']) > 150000 ||
        $_POST['price'] < 0 ||
        $_POST['price'] > 100000000 ||
        $_POST['quantity'] < 0 ||
        $_POST['quantity'] > 1000000000) {

        header('Location: ../../../view/error/error_400.php');
        die();
    }

    //Изображения
    $images = array();
    for ($i = 1; $i < 4; $i++) {

        $imagesDirectoryMove = null;
        $imagesDirectoryView = null;
        $imageInput = "pic$i";
        $tmpName = null;
        $userId = $_SESSION['loggedUser'];

        if (!empty($_FILES[$imageInput]['tmp_name'])) {

            $tmpName = $_FILES[$imageInput]['tmp_name'];

            if (!is_uploaded_file($tmpName)) {

                header('Location: ../../../view/error/error_400.php');
                die();
            }

            //Получаем формат, размер изображений
            $fileFormat = mime_content_type($tmpName);
            $type = explode("/", $fileFormat)[0];
            $extension = explode("/", $fileFormat)[1];
            $fileSize = filesize($tmpName);


            //Валидация изображения
            if ($type == "image" && $fileSize < 5048576) {

                $uploadTime = microtime();
                $fileName = $userId . $uploadTime . "." . $extension;

                $imagesDirectoryView = "../../web/uploads/productImages/$fileName";
                $imagesDirectoryMove = "../../../web/uploads/productImages/$fileName";

                move_uploaded_file($tmpName, $imagesDirectoryMove);
                cropImage($imagesDirectoryMove, 400);
                $imagesCatch[] = $imagesDirectoryMove;
                $images[] = $imagesDirectoryView;

            } else {
 
                header('Location: ../../../view/error/error_400.php');
                die();
            }
        } else {

            header('Location: ../../../view/error/error_400.php');
            die();
        }
    }


    //подкатегории и характеристики
    $subcatId = $_POST['subcategory_id'];
    $product->setSubcategoryId(htmlentities($subcatId));
    $specs = array();
    if(isset($_POST['specsCount'])){
        $specsCount = $_POST['specsCount'];
        for ($i = 0; $i < $specsCount; $i++) {
            $specValue = $_POST['specValue-' . $i];
            $specId = $_POST['specValueId-' . $i];
            $specObj = new \model\ProductSpecification();
            $specObj->setValue($specValue);
            $specObj->setSubcatSpecId($specId);
            $specs[] = $specObj;
        }
    }

    try {

        $productDao = \model\database\ProductsDao::getInstance();

        $id = $productDao->createNewProduct($product, $images, $specs);
        if ($id === false) {

            foreach ($imagesCatch as $dir) {
                unlink($dir);
            }

            header("Location: ../../../view/error/error_500.php");
            die();
        } else {
            echo $id;
        }

        header("Location: ../../../view/admin/products_promotions_reviews/products_view.php");

    } catch (PDOException $e) {


        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }

} else {

    try {
        $subcatDao = \model\database\SubCategoriesDao::getInstance();
        $subcategories = $subcatDao->getAllSubCategories();
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
}