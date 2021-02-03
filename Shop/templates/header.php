<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/indexFunction.php';
if (isConnectionCool() == false) {
    echo 'Ошибка соединения с базой данных, обратитесь к администратору';
    exit;
}
if ($_SERVER['REQUEST_URI'] == '/admin') {
    if (!isset($_SESSION['login'])) {
        header("Location:/authorization.php");
    } else {
        header("Location:/wellcome.php");
    }
} elseif ($_SERVER['REQUEST_URI'] === '/orders.php' && (!isset($_SESSION['groups'])
    || !(in_array("manager", $_SESSION['groups']) || in_array("administrator", $_SESSION['groups'])))) {
    header("Location:/denied.php");
} elseif (($_SERVER['REQUEST_URI'] === '/products.php' || $_SERVER['REQUEST_URI'] === '/add.php')
    && (!isset($_SESSION['groups']) || !in_array("administrator", $_SESSION['groups']))) {
    header("Location:/denied.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Fashion</title>

    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

    <meta name="theme-color" content="#393939">

    <link rel="preload" href="img/intro/coats-2018.jpg" as="image">
    <link rel="preload" href="fonts/opensans-400-normal.woff2" as="font">
    <link rel="preload" href="fonts/roboto-400-normal.woff2" as="font">
    <link rel="preload" href="fonts/roboto-700-normal.woff2" as="font">

    <link rel="icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="js/scripts.js" defer=""></script>
</head>
<body>
