<?php

namespace App\Repository;

use PDO;


class CommandeRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

  
   
}