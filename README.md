# Audit System

Application Laravel de gestion sécurisée des données avec journal d'audit.

## Fonctionnalités

- Authentification sécurisée avec CSRF, sessions Laravel et mots de passe hashés.
- Rôles `admin` et `utilisateur` protégés par middleware.
- CRUD utilisateurs réservé aux administrateurs.
- CRUD données avec consultation/ajout pour les utilisateurs et modification/suppression pour les administrateurs.
- Audit automatique des connexions, déconnexions, ajouts, modifications, suppressions et consultations importantes.
- Dashboard Bootstrap 5 avec compteurs, dernières activités et graphique Chart.js.

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configurer MySQL dans `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=audit_system
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=database
```

Créer la base `audit_system` dans phpMyAdmin ou MySQL, puis lancer :

```bash
php artisan migrate --seed
php artisan serve
```

Comptes de test :

- Admin : `admin@example.com` / `password`
- Utilisateur : `jean@example.com` / `password`

## Commandes Artisan de génération

```bash
php artisan make:controller AuthController
php artisan make:controller DashboardController
php artisan make:controller UserController --resource
php artisan make:controller DonneeController --resource
php artisan make:controller AuditLogController
php artisan make:model Donnee -mf
php artisan make:model AuditLog -m
php artisan make:middleware EnsureUserHasRole
php artisan make:migration add_role_to_users_table --table=users
php artisan migrate --seed
```

## Arborescence principale

```text
app/
  Http/Controllers/
    AuthController.php
    DashboardController.php
    UserController.php
    DonneeController.php
    AuditLogController.php
  Http/Middleware/EnsureUserHasRole.php
  Models/
    User.php
    Donnee.php
    AuditLog.php
  Services/AuditLogger.php
database/
  factories/DonneeFactory.php
  factories/UserFactory.php
  migrations/
    2026_05_19_000001_add_role_to_users_table.php
    2026_05_19_000002_create_donnees_table.php
    2026_05_19_000003_create_audit_logs_table.php
  seeders/DatabaseSeeder.php
resources/views/
  layouts/app.blade.php
  auth/login.blade.php
  dashboard.blade.php
  utilisateurs/
  donnees/
  audit/
routes/web.php
```

## Vérification

```bash
php artisan route:list
php artisan test
```
# audite_system
# audite_system
# audite_system
