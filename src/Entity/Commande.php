<?php

namespace App;

class Commande extends AbstractEntity
{
    private float $prixFinal;
    private bool $reductionAppliquee;

    public function __construct(
        float $prixFinal,
        bool $reductionAppliquee = false,
        ?\DateTime $dateCreation = null
    ) {
        parent::__construct($dateCreation);
        $this->prixFinal = $prixFinal;
        $this->reductionAppliquee = $reductionAppliquee;
    }

    public function getPrixFinal(): float
    {
        return $this->prixFinal;
    }

    public function setPrixFinal(float $prixFinal): void
    {
        $this->prixFinal = $prixFinal;
    }

    public function isReductionAppliquee(): bool
    {
        return $this->reductionAppliquee;
    }

    public function setReductionAppliquee(bool $reductionAppliquee): void
    {
        $this->reductionAppliquee = $reductionAppliquee;
    }
}