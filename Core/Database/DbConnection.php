<?php

declare(strict_types=1);

namespace Core\Database;

class DbConnection extends AbstractDb
{

    public function __construct(string $datasource, string $host, int $port, string $db, string $username, string $password)
    {
        try {
            parent::__construct($datasource, $host, $port, $db, $username, $password);
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    public function __destruct()
    {
        $this->setPdo(null);
    }
}