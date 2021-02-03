<?php

namespace App;

class Request
{
    public $request;

    public function __construct($var)
    {
        $this->request = $var;
    }
}
