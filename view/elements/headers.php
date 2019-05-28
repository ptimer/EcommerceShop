<?php
//Запускаем сессию
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Проверяем не заблокирован ли пользователь
require_once "../../utility/blocked_user.php";

?>



<!doctype html>
<html lang="en">
<head>

    <!-- Add Favicon -->
    <link rel="shortcut icon" href="../../web/assets/images/favicon.ico?v4" type="image/x-icon">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- Bootstrap CSS Library -->
    <link href="../../web/assets/css/bootstrap.css" rel='stylesheet' type='text/css'/>
    <!-- Main site CSS -->
    <link href="../../web/assets/css/style.css" rel='stylesheet' type='text/css'/>
    <!-- Navigation CSS -->
    <link href="../../web/assets/css/megaMenu.css" rel="stylesheet" type="text/css" media="all"/>

    <!-- JQuery Library -->
    <script src="../../web/assets/js/jquery-1.11.1.min.js"></script>
    <!-- Bootstrap JS Library -->
    <script src="../../web/assets/js/bootstrap.js"></script>
    <!-- Search JS -->
    <script type="text/javascript" src="../../web/assets/js/search.js"></script>
    <!-- Navigation JS -->
    <script type="text/javascript" src="../../web/assets/js/mega.menu.js"></script>
    <!-- Cart JS -->
    <script type="text/javascript" src="../../web/assets/js/cart/add.cart.js"></script>
    <!-- Cart Hover JS -->
    <script type="text/javascript" src="../../web/assets/js/cart/cart.hover.js"></script>

    <!-- Web fonts -->
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,300italic,600,700' rel='stylesheet'
          type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Slab:300,400,700' rel='stylesheet' type='text/css'>