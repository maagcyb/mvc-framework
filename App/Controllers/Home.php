<?php

namespace App\Controllers;

use Core\AbstractController;
use Core\View;

class Home extends AbstractController
{
    public function indexAction(): void
    {
        View::renderTemplate('Home/index.html', [
            'name' => 'Flo',
            'colors' => ['red', 'green', 'blue'],
        ]);
    }

    protected function before(): bool
    {
        return true;
    }

    protected function after(): void
    {
    }
}