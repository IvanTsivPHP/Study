<?php

function array_get($array, $key, $default = null)
{
    $keyArray = explode('.', $key);
    foreach ($keyArray as $item) {
        if (is_array($array) && in_array($array[$item], $array)) {
            $array = $array[$item];
        } else {
            return $default;
        }
    }

    return $array;
}

function includeView($templateName, $data = null)
{
    return require VIEW_DIR . '/' . $templateName . '.php';
}

function accessCheck($level) {
    if (isset($_SESSION['access'])) {
        $access = $_SESSION['access'];
    } else {
        $access = 0;
    }
    if ($access >= $level) {
        return true;
    }

    return false;
}
