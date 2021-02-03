<?php

namespace App\Controller;

abstract class Controller
{
    public $data = [];

    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }
}
