<?php

namespace App;

class Session
{
    private $cookieTime;


    // задаем время жизни сессионных кук
    public function __construct(string $cookieTime = '+30 days') {
        $this->cookieTime = strtotime($cookieTime);
        session_cache_limiter(false);
    }


    // стартуем сессию
    public function start()
    {
        session_start();
        if (empty($_SESSION)) {
            $this->defaultSessionValues();
        }
    }

    private function defaultSessionValues()
    {
        $_SESSION['access'] = 0;
    }

    /**
     * Проверяем сессию на наличие в ней переменной c заданным именем
     */
    public function has($name)
    {
        return isset($_SESSION[$name]);
    }



    /**
     * Устанавливаем сессию с именем $name и значением $value
     *
     *
     * @param $name
     * @param $value
     */
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }





    /**
     * Когда мы хотим сохранить в сессии сразу много значений - используем массив
     *
     * @param $vars
     */
    public function setArray(array $vars)
    {
        foreach($vars as $name => $value) {
            $this->set($name, $value);
        }
    }



    /**
     * Получаем значение сессий
     *
     * @param $name
     * @return mixed
     */
    public function get($name) {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $_SESSION[$name];
    }



    /**
     * @param $name - Уничтожаем сессию с именем $name
     */
    public function destroy($name) {
        unset($_SESSION[$name]);
    }



    /**
     * Полностью очищаем все данные пользователя
     */
    public function destroyAll() {
        session_destroy();
    }



    /**
     * Устанавливаем куки
     *
     * @param $name
     * @param $value
     */
    public function setCookie($name, $value) {
        setcookie($name, $value, $this->cookieTime);
    }



    /**
     * Получаем куки
     *
     * @param $name
     * @return mixed
     */
    public function getCookie($name) {
        return $_COOKIE[$name];
    }



    /**
     * @param $name Удалаяем
     */
    public function removeCookie($name) {
        setcookie($name, null);
    }
}

