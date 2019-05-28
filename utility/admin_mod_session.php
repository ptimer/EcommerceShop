<?php

// Начинаем сессию
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Проверяем авторизацию

if (!isset($_SESSION['role'])) {

    // Ошибка
    header("Location: ../../../view/error/error_400.php");
    die();
}

if (isset($_SESSION['role']) && $_SESSION['role'] != 3 && $_SESSION['role'] != 2) {

    // Перенаправляем ошибка
    header("Location: ../../../view/error/error_400.php");
    die();
}