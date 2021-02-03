<?php

namespace App\Controller;

use App\View\View;
use App\Model\Book;

class MainController extends Controller
{
    public function index(array $propArray = null)
    {
        $this->setData('title', 'Index Page');
        return new View('index', $this->data);
    }

    public function about(array $propArray = null)
    {
        $result = null;
        foreach ($propArray as $prop) {
            $result .= $prop . ', ';
        }
        $result = substr($result, 0 , -2);

        return 'about page text and props here: ' . $result;
    }

    public function signin(array $propArray = null)
    {
        $this->setData('title', 'Sign In');
        $this->setData('error', '');
        return new View('signin', $this->data);
    }

    public function signup(array $propArray = null)
    {
        $this->setData('title', 'Sign Up');
        return new View('signup', $this->data);
    }
}
