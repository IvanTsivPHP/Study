<?php

namespace App\Controller;

use App\View\View;
use App\Paginator;

class AdminController extends Controller
{
    public function users(array $propArray = null)
    {
        $this->setData('title', 'Users management');
        $this->setData('pagination', (new Paginator('Test', 5))->run());

        return new View('admin/users', $this->data);
    }
}
