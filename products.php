<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/admNavMenu.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
$query = 'SELECT products.id, products.name, categories.name AS category, new, sale, price 
FROM products, categories LEFT JOIN products_categories 
ON categories.id=category_id WHERE products.id = product_id ORDER BY products.id DESC';

$result = query($query);
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

$pevId = '0';
foreach ($products as $val) {
    $val = bolIntoString($val,'new');
    if ($val['id'] != $pevId) {
        $pevId = $val['id'];
        $refactoredProducts[] = $val;
    } else {
        $tmp = array_pop($refactoredProducts);
        $tmp['category'] = $tmp['category'] . " " . $val['category'];
        $refactoredProducts[] = $tmp;
    }

}

?>
<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <a class="page-products__button button" href="add.php">Добавить товар</a>
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
  </div>
  <ul class="page-products__list">
    <?php
    foreach ($refactoredProducts as $val) {
        echo "
        <li class=\"product-item page-products__item\">
            <b class=\"product-item__name\">" . $val['name'] . "</b>
            <span class=\"product-item__field\">" . $val['id'] . "</span>
             <span class=\"product-item__field\">" . $val['price'] . " руб.</span>
             <span class=\"product-item__field\">" . $val['category'] . "</span>
             <span class=\"product-item__field\">" . $val['new'] . "</span>
             <a href=\"add.php?id=" . $val['id'] . "\" class=\"product-item__edit\" aria-label=\"Редактировать\"></a>
             <button class=\"product-item__delete\" name='" . $val['id'] . "'></button>
        </li>
        ";
    }
    ?>
  </ul>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
