<?php

namespace App;

final class Config
{
    private static  $instance = null;
    private static $configs = [];
/*
 * Загружает все конфиг файлы с расширением .php из папки /configs в переменную
 */
    private static function configScoop()
    {
        chdir($_SERVER['DOCUMENT_ROOT'] . "/configs");
        $files = glob( "*.php");
        foreach ($files as $file) {
            static::$configs[substr($file, 0, -4)] = require $file;
        }
    }

    public static function get($config, $default = null)
    {
        return array_get(static::$configs, $config);
    }

    public static function getInstance(): Config
    {
        if (static::$instance === null) {
            static::$instance = new static();
            static::configScoop();
        }

        return static::$instance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
