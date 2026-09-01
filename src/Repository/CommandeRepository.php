<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Commande;
use PDO;

final class CommandeRepository implements CommandeRepositoryInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function save(Commande $commande): Commande
    {
        $sql = <<<'SQL'
            INSERT INTO commande (prix_final, reduction_appliquee)
            VALUES (:prix_final, :reduction_appliquee)
            RETURNING id, date_creation
        SQL;

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'prix_final' => $commande->getPrixFinal(),
            'reduction_appliquee' => $commande->isReductionAppliquee(),
        ]);

        $row = $statement->fetch();

        if ($row === false) {
            throw new \RuntimeException('Impossible de récupérer la commande créée.');
        }

        return new Commande(
            $commande->getPrixFinal(),
            $commande->isReductionAppliquee(),
            (int) $row['id'],
            new \DateTimeImmutable($row['date_creation'])
        );
    }
}
