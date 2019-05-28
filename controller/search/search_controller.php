<?php

require_once '../../utility/error_handler.php';

//Автолоадинг классов
function __autoload($className) {
    $className = '..\\..\\' . $className;
    require_once str_replace("\\", "/", $className) . '.php';
}


// Проверяем если запрос Ajax
if (isset($_GET['needle'])) {
    // Выводим пустой JSON если пусто
    if ($_GET['needle'] == "") {

        echo "{}";
    } else {

        //Пытаемся подкл к бд
        try {

            $searchDao = \model\database\ProductsDao::getInstance();

            $result = $searchDao->searchProduct($_GET['needle']);

            $resultJson = json_encode($result, JSON_UNESCAPED_SLASHES);
            echo $resultJson;


        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header('HTTP/1.1 500 Internal Server Error', true, 500);
            die();
        }

    }

} else {

    if (!trim($_GET['search']) == "") {

        try {
            $searchDao = \model\database\ProductsDao::getInstance();

            $result = $searchDao->searchProductNoLimit($_GET['search']);
        } catch (PDOException $e) {
            $message = date("Y-m-d H:i:s") . " " . $_SERVER['SCRIPT_NAME'] . " $e\n";
            error_log($message, 3, '../../errors.log');
            header('HTTP/1.1 500 Internal Server Error', true, 500);
            die();
        }

    } else {

        $result = array();
    }
}