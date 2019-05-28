<?php

// Начинаем сессию
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Авторизация
if (!isset($_SESSION['role'])) {

    header("Location: ../../../view/error/error_400.php");
    die();
}

if (isset($_SESSION['role']) && $_SESSION['role'] != 3) {

    header("Location: ../../../view/error/error_400.php");
    die();
}