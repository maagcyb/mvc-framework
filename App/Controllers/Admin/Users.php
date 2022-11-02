<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\AbstractController;

class Users extends AbstractController
{
    public function indexAction(): void
    {
        echo "index of UsersController";
    }

    protected function before(): bool
    {
        return true;
    }
}