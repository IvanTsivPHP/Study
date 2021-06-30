<section class="shop__sorting">
    <div class="shop__sorting-item custom-form__select-wrapper">
        <select class="custom-form__select" name="category">
            <option hidden="" value="price">Сортировка</option>
            <option value="price" <?= (isset($_GET['category']) && $_GET['category'] == 'price')?'selected':''?>>По цене</option>
            <option value="name" <?= (isset($_GET['category']) && $_GET['category'] == 'name')?'selected':''?>>По названию</option>
        </select>
    </div>
    <div class="shop__sorting-item custom-form__select-wrapper">
        <select class="custom-form__select" name="order">
            <option hidden="" value="asc">Порядок</option>
            <option value="asc" <?= (isset($_GET['order']) && $_GET['order'] == 'asc')?'selected':''?>>По возрастанию</option>
            <option value="desc" <?= (isset($_GET['order']) && $_GET['order'] == 'desc')?'selected':''?>>По убыванию</option>
        </select>
    </div>
    <p class="shop__sorting-res">Найдено <span class="res-sort"><?= $_SESSION['itemsCount']?></span> моделей</p>
</section>
</form>
<section class="shop__list">
