<?php

declare(strict_types=1);

namespace App\DTO;

final class CommandeDTO
{
    public function __construct(
        private readonly float $prixPanier,
        private readonly string $codePromotion
    ) {
        if ($prixPanier < 0) {
            throw new \InvalidArgumentException('Le prix du panier ne peut pas être négatif.');
        }
    }

    public function getPrixPanier(): float
    {
        return $this->prixPanier;
    }

    public function getCodePromotion(): string
    {
        return trim($this->codePromotion);
    }
}
