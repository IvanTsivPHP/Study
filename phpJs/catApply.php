<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
if(!isset($_SESSION))
{
    session_start();
}

if (isset($_POST['cat']) && $_SESSION['cat'] === $_POST['cat']) {
    $_SESSION['isCatSame'] = true;
} else {
    $_SESSION['isCatSame'] = false;
    $_SESSION['cat'] = $_POST['cat'];
    getPagination();
}

include $_SERVER['DOCUMENT_ROOT'] . '/templates/itemsCounter.php';
echo (showProductList(getProdList()));
