<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
var_dump($_POST);
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['phone'])) {
    $order = $_POST;
//Переводим строчные значения в бинарные для отправки в БД
    if ($order['delivery'] === 'dev-yes') {
        $order['delivery'] = 1;
    } else {
        $order['delivery'] = 0;
    }
    if ($order['pay'] === 'card') {
        $order['pay'] = 0;
    } else {
        $order['pay'] = 1;
    }
    $order['date'] = date('Y-m-d H:i:s', time());

    $query = "INSERT INTO orders
          SET
            product_id = '" . $order['id'] . "', 
            creation_time = '" . $order['date'] . "',
            customer_name = '" . $order['name'] . "',
            customer_surname = '" . $order['surname'] . "',
            customer_patronymic = '" . $order['thirdName'] . "',
            delivery = '" . $order['delivery'] . "',
            delivery_city = '" . $order['city'] . "',
            delivery_street = '" . $order['street'] . "',
            delivery_home = '" . $order['home'] . "',
            delivery_aprt = '" . $order['aprt'] . "',
            commentary = '" . $order['comment'] . "',
            customer_phone = '" . $order['phone'] . "',
            customer_email = '" . $order['email'] . "',
            cash_payment = '" . $order['pay'] . "', 
            price = '" . (int)$order['price'] . "'
";
    query($query);
    echo $_POST['price'];
}
