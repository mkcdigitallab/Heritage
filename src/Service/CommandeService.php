<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CommandeDTO;
use App\Entity\Commande;
use App\Repository\CommandeRepository;

final class CommandeService
{
    private const CODE_PROMOTION = 'PROMO10';
    private const TAUX_REDUCTION = 0.10;

    public function __construct(private readonly CommandeRepository $repository)
    {
    }

    public function creerCommande(CommandeDTO $dto): Commande
    {
        $prix = $dto->getPrixPanier();
        $reduction = strtoupper($dto->getCodePromotion()) === self::CODE_PROMOTION;

        if ($reduction) {
            $prix *= (1 - self::TAUX_REDUCTION);
        }

        $prix = round($prix, 2);

        $commande = new Commande($prix, $reduction);

        return $this->repository->save($commande);
    }
}
