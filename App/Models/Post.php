<?php

namespace App\Models;

use Core\Database\DbConnection;

class Post
{
    public static function getAll(DbConnection $db): array
    {
        $stmt = $db->connect()->query('SELECT * FROM posts');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}