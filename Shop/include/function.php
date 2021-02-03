<?php
function dump($var) {
    echo '<pre>';
    echo '</pre>';
}


function getConnection() {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/mysqlConfig.php';
    if (empty($db)){
        $db = mysqli_connect($host, $user, $password, $dbName);
    }
    return $db;
}

function query($query) {
    $connect = getConnection();
    $result =mysqli_query(
        $connect, "$query"
    );
    if ($result === false) {
        return false;
    }
    mysqli_close($connect);
    return $result;
}

function returnIdQuery($query) {
    $connect = getConnection();
    mysqli_query(
        $connect, "$query"
    );
    $result = mysqli_insert_id($connect);
    mysqli_close($connect);
    return $result;
}
function applyFilter($query) {
    if (isset($_GET['new']) && ($_GET['new'] == 'on')) {
        $query = $query . " AND new = 1";
    }
    if (isset($_GET['sale']) && $_GET['sale'] == 'on') {
        $query = $query . " AND sale = 1";
    }
    if (isset($_GET['min']) && isset($_GET['max'])) {

        $query = $query . " AND price BETWEEN " . dataFilter($_GET['min']) . " AND " . dataFilter($_GET['max']);
    }
    if (isset($_GET['category']) && isset($_GET['order'])) {
        $query = $query . " ORDER BY " . dataFilter($_GET['category']) . " " . dataFilter($_GET['order']);
    }
    if (isset($_GET['page'])) {
        $query = $query . " LIMIT " . (dataFilter($_GET['page'])-1)*6 . ",6";
    } else {
        $query = $query . " LIMIT " . "0,6";
    }
    return $query;
}

function getPagination() {
    $result = mysqli_fetch_assoc(query(applyFilter(queryTemplate('COUNT(*)'))));
    $_SESSION['itemsCount'] = $result['COUNT(*)'];

}

function categoryRefactor() {
    // ' WHERE id != 0' тут затычка, иначе дальше не прикрепить доп. условия из function applyFilter()
    $link = explode('?', $_SERVER['REQUEST_URI'], 2);
    switch ($link[0]) {
        case '/':
        case '/all': $res[0] = 0; $res[1] = ' WHERE id != 0'; break;
        case '/women': $res[0] = 1; break;
        case '/man': $res[0] = 2; break;
        case '/kids': $res[0] = 3; break;
        case '/accessories':$res[0] = 4; break;
        case '/new': $res[0] = 0; $res[1] = ' WHERE new = 1'; break;
        case '/sale': $res[0] = 0; $res[1] = ' WHERE sale = 1'; break;
    }
    return $res;
}

function queryTemplate($select = 'id, NAME, NEW, sale, price, picture') {
    $cat = categoryRefactor();
    if ($cat[0] == 0) {
        $query = "SELECT " . $select . " FROM products" . $cat[1];
    } else {
        $query = "SELECT " . $select . " 
                   FROM products inner  JOIN products_categories on id = product_id WHERE category_id = " . $cat[0];
    }

    return $query;
}

function getProdList() {

    $result = mysqli_fetch_all(query(applyFilter(queryTemplate())));
    if ($result){
        return $result;
    } else {
        return false;
    }
}

function showProductList($array) {
    //Расшифрлвка ключей: 0 - id товара, 1 - наименование, 2(bol) - флаг "Новинка", 3(bol) - флаг "Распродажа",
    //4 - цена, 5 - картинка
    $result = '';
    if ($array != 'empty') {
        foreach ($array as $value) {
            $result = $result . "<article class=\"shop__item product\" tabindex=\"0\">
                  <div class=\"product__id\" hidden>" . $value[0] . "</div>
                  <div class=\"product__image\">
                     <img src=\"img/products/" . $value[5] . "\" alt=\"product-name\">
                  </div>
                  <p class=\"product__name\">" . $value[1] . "</p>
                  <span class=\"product__price\">" . $value[4] . " руб.</span>
                  </article>";
        }
        $pages = ceil($_SESSION['itemsCount'] / 6);
        $url = explode("page", $_SERVER['REQUEST_URI']);
        if (isset($url[1])) {
            $url[0] = substr($url[0],0,-1);
        }
        if (strpos($url[0], '?' ) === false) {
            $pageString = "?page=";
        } else {
            $pageString = "&page=";
        }
        $result = $result . "</section>
              <ul class='shop__paginator paginator'>";
        for ($i = 1; $i <= $pages; $i++) {
            $href = $url[0] . $pageString . $i;
            if ($_SERVER['REQUEST_URI'] == $href) {
                $id = "style=\"color: #E45446\"";
            } else {
                $id = '';
            }
            $result = $result . "<li>
                <a class='paginator__item' " . $id . " href='" . $href ."'>" . $i . "</a>
                </li>";
        }
    }
    return $result;
}

function remove_key($key) {
    parse_str($_SERVER['QUERY_STRING'], $vars);
    $url = strtok( $_SERVER['REQUEST_URI'], '?') . "?" . http_build_query(array_diff_key($vars,array($key=>"")));
    return $url;
}

function getOrders() {
    $query = "SELECT * FROM orders";
    $result = query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    return $orders;
}

function sortOrders($orders) {
    foreach ($orders as $val) {
        if ($val['done_status'] == 0) {
            $notDone[] = $val;
        } else {
            $done[] = $val;
        }
    }
    $sortFunction = function($a, $b) {
        return $a['creation_time'] < $b['creation_time'];
    };
    if (empty($done)) {
        usort($notDone, $sortFunction);
        return $notDone;
    }
    if (empty($notDone)) {
        usort($done, $sortFunction);
        return $done;
    }
    usort($notDone, $sortFunction);
    usort($done, $sortFunction);
    $orders = array_merge($notDone, $done);
    return $orders;
}

function showOrdersList($orders) {
    foreach ($orders as $val) {
        if ($val['delivery'] == '1') {
            $val['delivery'] = 'Доставка';
            $val['hidden'] = '';
        } else {
            $val['delivery'] = 'Самовывоз';
            $val['hidden'] = 'hidden';
        }
        if ($val['cash_payment'] == '1') {
            $val['cash_payment'] = 'Наличными';
        } else {
            $val['cash_payment'] = 'Картой';
        }
        if ($val['done_status'] == '1') {
            $val['done_status'] = "<span class=\"order-item__info order-item__info--yes\">Выполнено</span>";
        } else {
            $val['done_status'] = "<span class=\"order-item__info order-item__info--no\">Не выполнено</span>";
        }
        echo "<li class=\"order-item page-order__item\">
      <div class=\"order-item__wrapper\">
        <div class=\"order-item__group order-item__group--id\">
          <span class=\"order-item__title\">Номер заказа</span>
          <span class=\"order-item__info order-item__info--id\">" . $val['id'] . "</span>
        </div>
        <div class=\"order-item__group\">
          <span class=\"order-item__title\">Сумма заказа</span>
          " . $val['price'] . " руб.
        </div>
        <button class=\"order-item__toggle\"></button>
      </div>
      <div class=\"order-item__wrapper\">
        <div class=\"order-item__group order-item__group--margin\">
          <span class=\"order-item__title\">Заказчик</span>
          <span class=\"order-item__info\">" . $val['customer_surname'] . " " . $val['customer_name'] . " " . $val['customer_patronymic'] . "</span>
        </div>
        <div class=\"order-item__group\">
          <span class=\"order-item__title\">Номер телефона</span>
          <span class=\"order-item__info\">" . $val['customer_phone'] . "</span>
        </div>
        <div class=\"order-item__group\">
          <span class=\"order-item__title\">Способ доставки</span>
          <span class=\"order-item__info\">" . $val['delivery'] . "</span>
        </div>
        <div class=\"order-item__group\">
          <span class=\"order-item__title\">Способ оплаты</span>
          <span class=\"order-item__info\">" . $val['cash_payment'] . "</span>
        </div>
        <div class=\"order-item__group order-item__group--status\">
          <span class=\"order-item__title\">Статус заказа</span>
          " . $val['done_status'] . "
          <button class=\"order-item__btn\">Изменить</button>
        </div>
      </div>
      <div class=\"order-item__wrapper\" " . $val['hidden'] . ">
        <div class=\"order-item__group\">
          <span class=\"order-item__title\">Адрес доставки</span>
          <span class=\"order-item__info\">г. " . $val['delivery_city'] . ", ул. " . $val['delivery_street'] . ", д."
            . $val['delivery_home'] .", кв. " . $val['delivery_aprt'] . "</span>
        </div>
      </div>
      <div class=\"order-item__wrapper\">
        <div class=\"order-item__group\">
          <span class=\"order-item__title\">Комментарий к заказу</span>
          <span class=\"order-item__info\">" . $val['commentary'] ."</span>
        </div>
      </div>
    </li>";
    }
}

function bolIntoString($array, $key) {
    if ($array[$key] == '1') {
        $array[$key] = 'Да';
    } elseif ($array[$key] == '0') {
        $array[$key] = 'Нет';
    }
    return $array;
}

function fileName($filename) {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
    $res = $filename;
    if (!file_exists($res)) return $res;
    $fnameNoExt = pathinfo($filename,PATHINFO_FILENAME);
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    $i = 1;
    while(file_exists("$fnameNoExt($i).$ext")) $i++;
    return "$fnameNoExt($i).$ext";
}

