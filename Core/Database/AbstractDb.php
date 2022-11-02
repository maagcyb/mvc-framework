<?php

declare(strict_types=1);

namespace Core\Database;

abstract class AbstractDb
{
    protected ?\PDO $pdo;
    protected string $datasource;
    protected string $dsn;
    protected string $host;
    protected string $db;
    protected int $port;
    protected string $username;
    protected string $password;

    public function __construct(string $datasource, string $host, int $port, string $db, string $username, string $password)
    {
        if ($datasource == 'mysql' || $datasource == 'pgsql'){
            $this->setDatasource($datasource);
        } else {
            throw new \Exception("Driver $datasource not supported");
        }

        $this->setHost($host);
        $this->setDb($db);
        $this->setPort($port);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setDsn($this->getDatasource() . ':host=' . $this->getHost() . ';port=' . $this->getPort() . ';dbname=' . $this->getDb());
    }

    public function connect(): \PDO
    {
        if (!isset($this->pdo)){
            $this->setPdo(new \PDO($this->getDsn(), $this->getUsername(), $this->getPassword()));
            $this->getPdo()->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $this->getPdo();
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
    /**
     * @param ?\PDO $pdo
     */
    public function setPdo(?\PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }
    /**
     * @param string $dsn
     */
    public function setDsn(string $dsn): void
    {
        $this->dsn = $dsn;
    }

    /**
     * @return string
     */
    public function getDatasource(): string
    {
        return $this->datasource;
    }
    /**
     * @param string $datasource
     */
    public function setDatasource(string $datasource): void
    {
        $this->datasource = $datasource;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }
    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }
    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }
    /**
     * @return string
     */
    public function getDb(): string
    {
        return $this->db;
    }
    /**
     * @param string $db
     */
    public function setDb(string $db): void
    {
        $this->db = $db;
    }
    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}