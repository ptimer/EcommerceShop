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

    //Валидация
    if (empty($_POST['pid']) ||
        strlen($_POST['title']) > 300 ||
        strlen($_POST['description']) > 150000 ||
        $_POST['price'] < 0 ||
        $_POST['price'] > 100000000 ||
        $_POST['quantity'] < 0 ||
        $_POST['quantity'] > 1000000000) {

        header('Location: ../../../view/error/error_400.php');
        die();
    }


    $product->setId($_POST['pid']);
    $product->setTitle(htmlentities($_POST['title']));
    $product->setDescription(htmlentities($_POST['description']));
    $product->setPrice(htmlentities($_POST['price']));
    $product->setQuantity(htmlentities($_POST['quantity']));


 
    $images = array();
    $pictureFlag = false;

        if(!empty($_FILES['pic1']['tmp_name']) &&
            !empty($_FILES['pic2']['tmp_name']) &&
            !empty($_FILES['pic3']['tmp_name'])) {

            $pictureFlag = true;

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

                //Получаем формат, размер изображения
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
    }


    //подкатегории и характеристики
    $subcatId = $_POST['subcategory_id'];
    $product->setSubcategoryId(htmlentities($subcatId));
    $oldSubcatId = $_POST['scid'];
    $specs = array();

        $specsCount = $_POST['specsCount'];
        for ($i = 0; $i < $specsCount; $i++) {
                $specValue = $_POST['specValue-' . $i];
                $specId = $_POST['specValueId-' . $i];
                $specObj = new \model\ProductSpecification();
                $specObj->setValue($specValue);

                if ($subcatId === $oldSubcatId) {
                    $specObj->setId($specId);
                    $specs[0]['newSubcat'] = 0;
                } else {
                    $specObj->setSubcatSpecId($specId);
                    $specs[0]['newSubcat'] = 1;
                }
                $specs[1][] = $specObj;
        }

    try {

        $productDao = \model\database\ProductsDao::getInstance();
        $productImagesDao = \model\database\ProductImagesDao::getInstance();

        $oldImgArr = $productImagesDao->getAllProductImages($_POST['pid']);
        $id = $productDao->editProduct($product, $images, $specs);
        if ($id === false) {
            foreach ($imagesCatch as $dir) {
                unlink($dir);
            }

            header("Location: ../../../view/error/error_500.php");
            die();
        }


            if($pictureFlag) {
                foreach ($oldImgArr as $img) {
                    unlink("../" . $img['image_url']);
                }
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
        $productDao = \model\database\ProductsDao::getInstance();
        $product = $productDao->getProductByIDAdmin($_GET['pid']);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
}