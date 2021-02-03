<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Application
{
    public $router;

    public function __construct($router)
    {
        $this->router = $router;
        $this->initialize();
    }

    public function initialize()
    {
        Config::getInstance();
        $capsule = new Capsule;
        $capsule->addConnection(Config::get('db'));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function run()
    {
        try {
            $result = $this->router->dispatch();
            if (!$result instanceof Renderable) {
                echo $result;
            } else {
                $result->render();
            }
        } catch (\Exception $e) {
            $this->renderException($e);
        }
    }

    public function renderException($exception)
    {
        if ($exception instanceof Renderable) {
            $exception->render();
        } elseif ($exception->getCode() == 0) {
            echo "500: Internal Server Error";
        } else {
            echo $exception->getCode() . ': ' . $exception->getMessage();
        }
    }
}
