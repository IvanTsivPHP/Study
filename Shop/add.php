<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/admNavMenu.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = null;
}

//Добудем уже имеющиеся данные на товар

if ($id !== 0) {
    $query = "SELECT name, price, picture, new, sale FROM products WHERE id =" . $id;
    $product = mysqli_fetch_assoc(query($query));
    $query = "SELECT category_id FROM products_categories WHERE product_id =" . $id;
    $result = query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $productCategory[] = $row['category_id'];
    }
} else {
    $product = [ 'name' => '', 'price' => '', 'picture' => '', 'new' => '0', 'sale' => '0'];
    $productCategory = [''];
}
?>
<main class="page-add">
  <h1 class="h h--1"><?=isset($_GET['id'])?'Изменение товара':'Добавление товара'?></h1>
  <form id="uploadForm" class="custom-form" action="#" method="post">
      <input hidden type="text" name="id" value="<?=$id?>">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?=$product['name']?>">
        <p class="custom-form__input-label" <?= !empty($product['name'])?'hidden':''?>>
          Название товара
        </p>
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?=$product['price']?>">
        <p class="custom-form__input-label" <?= !empty($product['price'])?'hidden':''?>>
          Цена товара
        </p>
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
        <input hidden type="text" name="oldPicture" value="<?=$product['picture']?>">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <ul class="add-list">

        <li class="add-list__item add-list__item--add">
          <input type="file" name="product-photo" id="product-photo" hidden="" >
          <label for="product-photo">Добавить фотографию</label>
        </li>
         <?php
         if (!empty($product['picture']))
         {
             include $_SERVER['DOCUMENT_ROOT'] . '/templates/preloadImageLi.php';
         }
         ?>

      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple">
          <option hidden="">Название раздела</option>
          <option value="1" <?=in_array('1', $productCategory)?'selected':''?>>Женщины</option>
          <option value="2" <?=in_array('2', $productCategory)?'selected':''?>>Мужчины</option>
          <option value="3" <?=in_array('3', $productCategory)?'selected':''?>>Дети</option>
          <option value="4" <?=in_array('4', $productCategory)?'selected':''?>>Аксессуары</option>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?=$product['new'] == '1'?'checked':''?>>
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?=$product['sale'] == '1'?'checked':''?>>
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <button class="button" type="submit"><?=isset($_GET['id'])?'Сохранить изменения':'Добавить товар'?></button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно <?=isset($_GET['id'])?'изменен':'добавлен'?></h2>
    </div>
  </section>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
