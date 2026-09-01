<?php

declare(strict_types=1);

use App\Controller\CommandeController;
use App\Core\Database;
use App\Repository\CommandeRepository;
use App\Service\CommandeService;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '5432';
$database = getenv('DB_NAME') ?: 'heritage';
$username = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: '';

try {
    $databaseConnection = new Database($host, $port, $database, $username, $password);
    $repository = new CommandeRepository($databaseConnection->getConnection());
    $service = new CommandeService($repository);
    $controller = new CommandeController($service);

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

    if ($method === 'POST' && $path === '/commande') {
        echo $controller->enregistrer($_POST);
        exit;
    }

    echo $controller->formulaire();
} catch (Throwable $exception) {
    http_response_code(500);
    echo '<h1>Erreur de configuration</h1><p>Vérifiez la connexion PostgreSQL et les variables DB_*.</p>';
}
