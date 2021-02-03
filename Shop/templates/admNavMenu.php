<header class="page-header">
    <a class="page-header__logo" href="#">
        <img src="img/logo.svg" alt="Fashion">
    </a>

    <a class="page-header__logo" href="#">
        <img src="img/logo.svg" alt="Fashion">
    </a>
    <nav class="page-header__menu">
        <ul class="main-menu main-menu--header">
            <li>
                <a class="main-menu__item" href="/">Главная</a>
            </li>
            <li>
                <a class="main-menu__item<?=$_SERVER['REQUEST_URI'] == '/products.php'?' active':''?>" href="products.php">Товары</a>
            </li>
            <li>
                <a class="main-menu__item<?=$_SERVER['REQUEST_URI'] == '/orders.php'?' active':''?>" href="orders.php">Заказы</a>
            </li>
            <li>
                <a class="main-menu__item" href="authorization.php?logout=true">Выйти</a>
            </li>
        </ul>
    </nav>
</header>