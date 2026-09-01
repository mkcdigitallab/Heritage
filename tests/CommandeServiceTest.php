<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\DTO\CommandeDTO;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Service\CommandeService;

final class FakeCommandeRepository extends CommandeRepository
{
}

// Test unitaire léger : on vérifie l'entité et le calcul de réduction sans accès SQL.
$repository = new class {
    public ?Commande $saved = null;

    public function save(Commande $commande): Commande
    {
        $this->saved = $commande;
        return $commande;
    }
};

$service = new CommandeService($repository);
$commande = $service->creerCommande(new CommandeDTO(100.00, 'PROMO10'));

assert($commande->getPrixFinal() === 90.00);
assert($commande->isReductionAppliquee() === true);
assert($commande->getId() === null);

echo "Tests CommandeService : OK\n";
