<?php

declare(strict_types=1);

use App\Controller\CommandeController;
use App\Core\Database;
use App\Repository\CommandeRepository;
use App\Service\CommandeService;

require_once dirname(__DIR__) . '/vendor/autoload.php';

function loadEnv(string $file): void
{
    if (!is_file($file)) {
        return;
    }

    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        $value = trim($value, "\"'");

        if ($key !== '' && getenv($key) === false) {
            putenv($key . '=' . $value);
        }
    }
}

loadEnv(dirname(__DIR__) . '/.env');

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
    error_log($exception->__toString());
    echo '<h1>Erreur de configuration</h1>';
    echo '<p>Impossible de se connecter à PostgreSQL.</p>';
    echo '<p>Vérifiez votre fichier <code>.env</code> et les variables <code>DB_*</code>.</p>';
}
