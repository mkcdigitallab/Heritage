<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Commande;

interface CommandeRepositoryInterface
{
    public function save(Commande $commande): Commande;
}
