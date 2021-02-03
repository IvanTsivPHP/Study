<?php

namespace App\Exception;

use App\Renderable;

class NotFoundException extends HttpException implements Renderable
{
    public function render()
    {
        echo 'Страница не найдена.';
    }
}
