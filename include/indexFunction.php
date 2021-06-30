<?php
function activeHighlight($id) {
    $link = explode('?', $_SERVER['REQUEST_URI'], 2);
    if ($id == $link[0]) {
        return 'active';
    }
}

function dataFilter($string) {
    $string = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$string);
    return $string;
}

function isConnectionCool() {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/mysqlConfig.php';
    if (empty($connect)){
        $connect = mysqli_connect($host, $user, $password, $dbName);
    }
    if ($connect == false) {
        return false;
    }
    mysqli_close($connect);
    return true;
}