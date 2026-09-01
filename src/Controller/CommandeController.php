<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CommandeDTO;
use App\Service\CommandeService;
use Throwable;

final class CommandeController
{
    public function __construct(private readonly CommandeService $service)
    {
    }

    public function enregistrer(array $post): string
    {
        try {
            $prix = filter_var($post['prix_panier'] ?? null, FILTER_VALIDATE_FLOAT);
            $code = is_string($post['code_promotion'] ?? null) ? $post['code_promotion'] : '';

            if ($prix === false || $prix < 0) {
                return $this->renderForm('Veuillez saisir un prix de panier valide.');
            }

            $commande = $this->service->creerCommande(new CommandeDTO($prix, $code));

            $reduction = $commande->isReductionAppliquee() ? 'Oui' : 'Non';

            return '<!doctype html><html lang="fr"><head><meta charset="utf-8"><title>Commande</title></head><body>'
                . '<h1>Commande enregistrée</h1>'
                . '<p>ID : ' . htmlspecialchars((string) $commande->getId(), ENT_QUOTES, 'UTF-8') . '</p>'
                . '<p>Prix final : ' . htmlspecialchars(number_format($commande->getPrixFinal(), 2, ',', ' '), ENT_QUOTES, 'UTF-8') . '</p>'
                . '<p>Réduction appliquée : ' . $reduction . '</p>'
                . '<p><a href="/">Nouvelle commande</a></p>'
                . '</body></html>';
        } catch (Throwable $exception) {
            return $this->renderForm('Une erreur est survenue : ' . $exception->getMessage());
        }
    }

    public function formulaire(?string $message = null): string
    {
        return $this->renderForm($message);
    }

    private function renderForm(?string $message = null): string
    {
        $messageHtml = $message === null ? '' : '<p><strong>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</strong></p>';

        return '<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Enregistrer une commande</title></head><body>'
            . '<h1>Enregistrer une commande</h1>'
            . $messageHtml
            . '<form method="post" action="/commande">'
            . '<label for="prix_panier">Prix du panier</label><br>'
            . '<input id="prix_panier" name="prix_panier" type="number" min="0" step="0.01" required><br><br>'
            . '<label for="code_promotion">Code promotionnel</label><br>'
            . '<input id="code_promotion" name="code_promotion" type="text" maxlength="50"><br><br>'
            . '<button type="submit">Valider la commande</button>'
            . '</form></body></html>';
    }
}
