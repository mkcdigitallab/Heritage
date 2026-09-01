# Heritage

Projet pédagogique e-commerce en PHP 8.2+, POO et PostgreSQL.

## Architecture

- `Core` : infrastructure commune, dont `AbstractEntity` et PDO.
- `Entity` : objets métier persistables.
- `DTO` : transport et validation minimale des données entrantes.
- `Repository` : accès aux données PostgreSQL.
- `Service` : logique métier et calcul des réductions.
- `Controller` : orchestration HTTP.
- `public` : point d'entrée de l'application.
- `database` : schéma SQL.
- `tests` : tests légers du métier.

## Installation

```bash
composer install
composer dump-autoload
```

Créer la base PostgreSQL puis exécuter `database/schema.sql`.

Configurer les variables `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` et `DB_PASSWORD` dans l'environnement.

Lancer le serveur de développement :

```bash
php -S 127.0.0.1:8000 -t public public/index.php
```

Puis ouvrir `http://127.0.0.1:8000/`.

## Règle métier

Le code `PROMO10` applique une réduction de 10 % au prix du panier. Le calcul est réalisé dans `CommandeService`, jamais dans le Controller ni dans le Repository.

## Test

Après `composer dump-autoload` :

```bash
php -d zend.assertions=1 -d assert.exception=1 tests/CommandeServiceTest.php
```

## Git

Le projet suit Conventional Commits : `feat:`, `fix:`, `test:`, `chore:`.
