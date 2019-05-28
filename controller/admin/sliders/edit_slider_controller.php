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
    $slider = new \model\Slider();


    $slider->setTitle(htmlentities($_POST['title']));
    $slider->setHref($_POST['href']);
    $slider->setId($_POST['sid']);

    $imagesDirectoryMove = null;
    $imagesDirectoryView = null;
    $tmpName = null;
    $userId = $_SESSION['loggedUser'];

    if (!empty($_FILES["pic1"]['tmp_name'])) {

        $tmpName = $_FILES["pic1"]['tmp_name'];

        if (!is_uploaded_file($tmpName)) {

            header('Location: ../../../view/error/error_400.php');
            die();
        }


    // Получаем расширение, размер изображений
    $fileFormat = mime_content_type($tmpName);
    $type = explode("/", $fileFormat)[0];
    $extension = explode("/", $fileFormat)[1];
    $fileSize = filesize($tmpName);


        // Валидация изобр. Меньше 5мб
        if ($type == "image" && $fileSize < 5048576) {

            $uploadTime = microtime();
            $fileName = $userId . $uploadTime . "." . $extension;

            $imagesDirectoryView = "../../web/uploads/sliderImages/$fileName";
            $imagesDirectoryMove = "../../../web/uploads/sliderImages/$fileName";

            move_uploaded_file($tmpName, $imagesDirectoryMove);
            $slider->setImage($imagesDirectoryView);

        } else {

            header('Location: ../../../view/error/error_400.php');
            die();
        }
    }


    try {

        $sliderDao = \model\database\SliderDao::getInstance();

        $id = $sliderDao->EditSlider($slider);
        if ($id === false) {

            header("Location: ../../../view/error/error_500.php");
            die();
        } else {
            echo $id;
        }

        header("Location: ../../../view/admin/sliders/slider_view.php");

    } catch (PDOException $e) {


        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }

}