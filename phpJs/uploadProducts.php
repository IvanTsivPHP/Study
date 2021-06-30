<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
// Валидация введенных данных
if ((empty($_POST['product-name']) || empty($_POST['product-price']) || (empty($_FILES['product-photo']) && !isset($_POST['oldPicture'])) || !isset($_POST['category']))) {
    $valid = false;
} else {
    $valid = true;
}
if ($valid === true) {
//Загрузка картинки
    if (!empty($_FILES['product-photo'])) {
        $pictureName = fileName($_FILES['product-photo']['name']);
        move_uploaded_file($_FILES['product-photo']['tmp_name'], "$dir/$pictureName");
    } else {
        $pictureName = $_POST['oldPicture'];
    }
    if (isset($_POST['new'])) {
        $_POST['new'] = 1;
    } else {
        $_POST['new'] = 0;
    }
    if (isset($_POST['sale'])) {
        $_POST['sale'] = 1;
    } else {
        $_POST['sale'] = 0;
    }

    if ($_POST['id'] == '0') {
        $query = "INSERT INTO products (name, new, sale, price, picture )
              VALUES ('" . ($_POST['product-name']) . "', " . $_POST['new'] . ", " . $_POST['sale'] . ", " . $_POST['product-price'] . ", '" . $pictureName . "')";
        $result = returnIdQuery($query);
        $query = "INSERT INTO products_categories (product_id, category_id) VALUES";
        foreach ($_POST['category'] as $value) {
            $query = $query . " (" . $result . ", " . $value . "),";
        }
        $query = substr($query, 0, -1);
        query($query);

    } else {
        $query = "UPDATE products SET name= '" . $_POST['product-name'] . "', new=" . $_POST['new'] . ", sale=" . $_POST['sale']
            . ", price=" . $_POST['product-price'] . ", picture='" . $pictureName . "'  WHERE  id=" . $_POST['id'];
        query($query);
        query("DELETE FROM products_categories WHERE  product_id=" . $_POST['id']);
        $query = "INSERT INTO products_categories (product_id, category_id) VALUES";
        foreach ($_POST['category'] as $value) {
            $query = $query . " (" . $_POST['id'] . ", " . $value . "),";
        }
        $query = substr($query, 0, -1);
        query($query);
    }
} else {
    echo "Все поля должны быть отмечены";
}

