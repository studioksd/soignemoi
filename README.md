# SoigneMoi

## Requirements

- Symfony 6.4.X
- PHP 8.2
- Composer
- PostgreSQL

## Installation

1. Cloner le repository:
   git clone https://github.com/studioksd/soignemoi.git

2. Installer les dépendences:
    composer install

3. Modifier le .env avec vos variables d'environnement

4. Créer le schéma de base de données:
    php bin/console doctrine:schema:update --force

5. Lancer le serveur:
    symfony server:start
    Il est également possible d'utiliser un serveur web (Apache2, etc.) si souhaité.

6. Accéder à l'application:
    http://localhost:8000
    (ou l'adresse définie dans la configuration de votre serveur web)