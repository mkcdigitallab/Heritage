<?php

declare(strict_types=1);

namespace App\Entity;

use App\Core\AbstractEntity;

class Commande extends AbstractEntity
{
    private float $prixFinal;
    private bool $reductionAppliquee;

    public function __construct(
        float $prixFinal,
        bool $reductionAppliquee = false,
        ?int $id = null,
        ?\DateTimeImmutable $dateCreation = null
    ) {
        parent::__construct($id, $dateCreation);
        $this->setPrixFinal($prixFinal);
        $this->reductionAppliquee = $reductionAppliquee;
    }

    public function getPrixFinal(): float
    {
        return $this->prixFinal;
    }

    public function setPrixFinal(float $prixFinal): void
    {
        if ($prixFinal < 0) {
            throw new \InvalidArgumentException('Le prix final ne peut pas être négatif.');
        }

        $this->prixFinal = $prixFinal;
    }

    public function isReductionAppliquee(): bool
    {
        return $this->reductionAppliquee;
    }
}
