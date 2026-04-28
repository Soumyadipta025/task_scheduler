<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Default language */
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'hi';
}

/* Handle language change */
if (isset($_GET['lang'])) {
    $allowed = ['en', 'hi'];
    if (in_array($_GET['lang'], $allowed)) {
        $_SESSION['lang'] = $_GET['lang'];
    }
}

/* Load language file */
$langFile = __DIR__ . "/languages/" . $_SESSION['lang'] . ".php";
if (file_exists($langFile)) {
    $lang = include $langFile;
} else {
    $lang = include __DIR__ . "/languages/en.php";
}
