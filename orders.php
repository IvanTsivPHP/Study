<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/admNavMenu.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
?>

<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <ul class="page-order__list">

      <?php
      showOrdersList(sortOrders(getOrders()));
      ?>

  </ul>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
