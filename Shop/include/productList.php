<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
// Проверяем изменялись ли фильтры
if (isset($_SESSION['filter'])) {
    $prevFilter = array_intersect_key($_GET, array_flip(['min', 'max', 'sale', 'new', 'category','order']));
    if (empty($prevFilter) || ($_SESSION['filter'] == $prevFilter)) {
        $_SESSION['isFilterSame'] = true;
    } else {
        $_SESSION['filter'] = $prevFilter;
        $_SESSION['isFilterSame'] = false;
    }
} else {
    $_SESSION['filter'] = '0';
    $_SESSION['isFilterSame'] = false;
}

if (!isset($_SERVER['QUERY_STRING']) || strpos($_SERVER['QUERY_STRING'], 'page' ) === false) {
    getPagination();
}
include $_SERVER['DOCUMENT_ROOT'] . '/templates/itemsCounter.php';
echo showProductList(getProdList());
