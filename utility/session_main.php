<?php

// Начинаем сессию
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Авториазован ?
if (isset($_SESSION['loggedUser'])) {

    // На основную
    header('Location: ../../view/main/index.php');
    die();
}