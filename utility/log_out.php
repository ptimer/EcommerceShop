<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

unset($_SESSION['role']);

session_destroy();

header("Location: ../view/main/index.php");