<?php

namespace App\View;

use App\Exception\NotFoundException;
use App\Renderable;

class View implements Renderable
{
    public $file;
    public $props;
    public $header;
    public $footer;

    public function __construct($file, $props = null, $defaultHeader = 'base/header', $defaultFooter = 'base/footer')
    {
        $this->file = $file;
        $this->props = $props;
        $this->header = $defaultHeader;
        $this->footer = $defaultFooter;
    }

    public function render()
    {
        $path = VIEW_DIR . '/' . str_replace('.', '/', $this->file) . '.php';
        if (file_exists($path)) {
            includeView($this->header, $this->props);
            includeView($this->file, $this->props);
            includeView($this->footer, $this->props);
        } else {
            throw new NotFoundException();
        }
    }
}
