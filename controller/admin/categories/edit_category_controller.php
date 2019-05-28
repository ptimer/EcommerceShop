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
    $category = new \model\Category();

    //Валидация
    if (empty($_POST['name']) || strlen($_POST['name']) > 40 ){
        header('Location: ../../../view/error/error_400.php');
        die();
    }


    try {

        $catDao = \model\database\CategoriesDao::getInstance();

        $category->setName(htmlentities($_POST['name']));
        $category->setSupercategoryId(htmlentities($_POST['supercategory_id']));
        $category->setId($_POST['cat_id']);


        $catDao->editCategory($category);

        header("Location: ../../../view/admin/categories/categories_view.php");


    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }

} else {
    try {
        $catId = $_GET['cid'];
        $supercatDao = \model\database\SuperCategoriesDao::getInstance();
        $catDao = \model\database\CategoriesDao::getInstance();
        $supercategories = $supercatDao->getAllSuperCategories();
        $cat = $catDao->getCategoryById($catId);
    } catch (PDOException $e) {
        $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
        error_log($message, 3, '../../../errors.log');
        header("Location: ../../../view/error/error_500.php");
        die();
    }
}