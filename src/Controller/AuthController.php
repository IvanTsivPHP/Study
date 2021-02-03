<?php

namespace App\Controller;

use App\Model\User;
use App\Request;
use App\View\View;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->setData('post', (new Request($_POST))->request);
    }

    public function login()
    {
        if ($this->passwordVerify()) {
            $_SESSION['access'] = $this->data['user']['access_level'];


            header('Location: /');
        } else {
            $this->setData('title', 'Sign In');
            $this->setData('error', 'Wrong login or password');
            return new View('signin', $this->data);
        }
    }

    public function passwordVerify()
    {
        $this->setData('user', User::where('email', $this->data['post']['email'])
            ->get());
        if ($this->data['user']->has(0)) {
            $this->setData('user', $this->data['user']->toArray()[0]);
            if (password_verify($this->data['post']['password'], $this->data['user']['password'])) {
                return true;
            }
        }

        return false;
    }

    public  function logout()
    {
        unset($_SESSION['access']);

        header('Location: /');
    }
}
