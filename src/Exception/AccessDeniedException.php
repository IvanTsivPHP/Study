<?php

namespace App\Exception;

use App\Renderable;

class AccessDeniedException extends HttpException implements Renderable
{
    public function render()
    {
        echo 'Недостаточно прав для просмотра этой страницы';
    }
}
