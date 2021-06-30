<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';

query('DELETE FROM products WHERE  id=' . $_POST['id']);
query('DELETE FROM products_categories WHERE  product_id=' . $_POST['id']);