<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
$price = (int)$_POST['price'];
if ($price < $freeDelivery) {
    $price = $price + $delivery;
}
echo $price . ' руб.';
