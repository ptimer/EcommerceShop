<?php

// Начинаем сессию
session_start();

// Авторизация
if (!isset($_SESSION['loggedUser'])) {

    // На главную
    header('Location: ../main/index.php');
    die();
}