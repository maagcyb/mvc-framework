<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Config;
use App\Models\Post;
use Core\AbstractController;
use Core\View;
use Core\Database\DbConnection;

class Posts extends AbstractController
{
    public function indexAction(): void
    {
        $db = new DbConnection(Config::DB_DATASOURCE, Config::DB_HOST, Config::DB_PORT, Config::DB_NAME, Config::DB_USER, Config::DB_PW);
        $posts = Post::getAll($db);
        View::renderTemplate('Posts/index.html', [
            'posts' => $posts,
        ]);
        unset($db);
    }

    public function editAction(): void
    {
        echo "I'm the edit function of the PostsController<br>";
        echo 'Route Parameters: <pre>' .
            htmlspecialchars(print_r($this->getRouteParams(), true)) . '</pre>';
    }
}