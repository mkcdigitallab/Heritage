<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

final class Database
{
    private PDO $connection;

    public function __construct(
        string $host,
        string $port,
        string $database,
        string $username,
        string $password
    ) {
        $dsn = "pgsql:host={$host};port={$port};dbname={$database}";

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
