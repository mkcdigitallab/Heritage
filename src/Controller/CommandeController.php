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
            $prix = filter_var($post['prix_final'] ?? null, FILTER_VALIDATE_FLOAT);
            $code = is_string($post['code_promo'] ?? null) ? $post['code_promo'] : '';

            if ($prix === false || $prix < 0) {
                return $this->renderForm('Veuillez saisir un prix valide.', true);
            }

            $commande = $this->service->creerCommande(new CommandeDTO($prix, $code));
            $reduction = $commande->isReductionAppliquee() ? 'Oui' : 'Non';

            return '<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><script src="https://cdn.tailwindcss.com"></script><title>Commande enregistrée</title></head>'
                . '<body class="bg-gray-100 min-h-screen flex items-center justify-center"><div class="bg-white w-full max-w-md p-6 rounded-lg shadow-md">'
                . '<h1 class="text-2xl font-bold text-gray-800 mb-6">Commande enregistrée</h1>'
                . '<div class="space-y-3 text-gray-700">'
                . '<p><span class="font-semibold">ID :</span> ' . htmlspecialchars((string) $commande->getId(), ENT_QUOTES, 'UTF-8') . '</p>'
                . '<p><span class="font-semibold">Prix final :</span> ' . htmlspecialchars(number_format($commande->getPrixFinal(), 2, ',', ' '), ENT_QUOTES, 'UTF-8') . '</p>'
                . '<p><span class="font-semibold">Réduction appliquée :</span> ' . $reduction . '</p>'
                . '</div><a href="/" class="block w-full text-center mt-6 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">Nouvelle commande</a>'
                . '</div></body></html>';
        } catch (Throwable $exception) {
            return $this->renderForm('Une erreur est survenue : ' . $exception->getMessage(), true);
        }
    }

    public function formulaire(?string $message = null): string
    {
        return $this->renderForm($message);
    }

    private function renderForm(?string $message = null, bool $error = false): string
    {
        $messageHtml = $message === null ? '' : '<div class="mb-4 rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</div>';

        return '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer une commande</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Enregistrer une commande</h1>
        ' . $messageHtml . '
        <form method="POST" action="/commande">
            <div class="mb-4">
                <label for="prix_final" class="block text-sm font-medium text-gray-700 mb-1">Prix final</label>
                <input type="number" name="prix_final" id="prix_final" min="0" step="0.01" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ex : 25000">
            </div>

            <div class="mb-4">
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer">
                    <input type="checkbox" id="activer_promo" class="h-4 w-4" onchange="togglePromo()">
                    J'ai un code promo
                </label>
            </div>

            <div id="promo_container" class="mb-6 hidden">
                <label for="code_promo" class="block text-sm font-medium text-gray-700 mb-1">Code promo</label>
                <input type="text" name="code_promo" id="code_promo" maxlength="50"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase"
                    placeholder="Ex : PROMO10">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                Enregistrer la commande
            </button>
        </form>
    </div>

    <script>
        function togglePromo() {
            const checkbox = document.getElementById('activer_promo');
            const container = document.getElementById('promo_container');
            const input = document.getElementById('code_promo');
            container.classList.toggle('hidden', !checkbox.checked);
            input.required = checkbox.checked;
            if (!checkbox.checked) input.value = '';
        }
    </script>
</body>
</html>';
    }
}
