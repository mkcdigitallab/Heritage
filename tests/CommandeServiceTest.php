<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\DTO\CommandeDTO;
use App\Entity\Commande;
use App\Repository\CommandeRepositoryInterface;
use App\Service\CommandeService;

final class FakeCommandeRepository implements CommandeRepositoryInterface
{
    public ?Commande $saved = null;

    public function save(Commande $commande): Commande
    {
        $this->saved = $commande;
        return $commande;
    }
}

$repository = new FakeCommandeRepository();
$service = new CommandeService($repository);

$commande = $service->creerCommande(new CommandeDTO(100.00, 'PROMO10'));
assert($commande->getPrixFinal() === 90.00);
assert($commande->isReductionAppliquee() === true);

$commandeSansReduction = $service->creerCommande(new CommandeDTO(100.00, ''));
assert($commandeSansReduction->getPrixFinal() === 100.00);
assert($commandeSansReduction->isReductionAppliquee() === false);

echo "Tests CommandeService : OK\n";
