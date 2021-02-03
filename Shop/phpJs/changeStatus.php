<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
if ($_POST['status'] === 'Выполнено') {
    $stat = 1;
} elseif ($_POST['status'] === 'Не выполнено') {
    $stat = 0;
}

$query = "UPDATE orders SET done_status = " . $stat . " WHERE  id=" . $_POST['id'];
query($query);
echo $query;
