<?php

require_once '../../../utility/error_handler_dir_back.php';

require_once '../../../utility/admin_session.php';
//Автолоадинг классов
function __autoload($className)
{
    $className = '..\\..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}

if (isset($_POST['submit'])) {
    $supercategory = new \model\SuperCategory();

    //Валидация
    if (empty($_POST['name']) || strlen($_POST['name']) > 40 ){
        header('Location: ../../../view/error/error_400.php');
        die();
    }

    //Пытаемся подкл к бд
    try {

        $supercatDao = \model\database\SuperCategoriesDao::getInstance();

        $supercategory->setName(htmlentities($_POST['name']));
        $supercategory->setId($_POST['supercat_id']);


        $supercatDao->editSuperCategory($supercategory);

        header("Location: ../../../view/admin/supercategories/supercategories_view.php");


    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
} else {
    try {
        $superCatId = $_GET['scid'];
        $supercatDao = \model\database\SuperCategoriesDao::getInstance();
        $superCat = $supercatDao->getSuperCategoryById($superCatId);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
}