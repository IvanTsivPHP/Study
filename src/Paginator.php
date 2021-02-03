<?php

namespace App;

class Paginator
{
    private $pages;
    private $model;
    private $limit;


    public function __construct($model, $defaultLimit)
    {
        $this->model = 'App\Model\\' . $model;
        $this->limit = $defaultLimit;
    }

    public function run()
    {
        if ($this->limitChange() || !$this->checkCache()) {
            $this->calcPages();
            $this->setCookie();
            return ['pages' => $this->pages, 'limit' => $this->limit];
        }

        return $_COOKIE['pagination@' . $this->model];

    }

    public function checkCache()
    {
        if (isset($_COOKIE['pagination@' . $this->model])) {
            $this->pages = $_COOKIE['pagination@' . $this->model]['pages'];
            $this->limit = $_COOKIE['pagination@' . $this->model]['limit'];
            return true;
        }

        return false;
    }

    public function limitChange()
    {
        if (isset($_GET['lim'])) {
            $this->limit = $_GET['lim'];
            return true;
        }

        return false;
    }

    public function setCookie()
    {
        setcookie('pagination@' . $this->model . '[pages]', $this->pages , time()+600);
        setcookie('pagination@' . $this->model . '[limit]', $this->limit , time()+600);
    }

    private function calcPages()
    {
        $items = $this->model::count();
        $this->pages = ceil($items / $this->limit);
    }

}
