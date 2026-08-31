<?php

namespace App\CommandeDTO;


class CommandeDTO
{
    public float $prixFinal;
    public bool $reductionAppliquee;

    public function __construct(float $prixFinal, bool $reductionAppliquee)
    {
        $this->prixFinal = $prixFinal;
        $this->reductionAppliquee = $reductionAppliquee;
    }
    public static function fromArray(array $data): self
    {
        return new self(($data['prix_final'] ?? 0),($data['reduction_appliquee'] ?? false)
        );
    }
}

