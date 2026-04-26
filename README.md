# ViserMart Backoffice

Backoffice e-commerce développé avec Laravel pour la gestion d’une boutique en ligne : produits, catégories, marques, commandes, paiements, promotions, utilisateurs, tickets support, paramètres système et localisation. Un README clair à la racine du dépôt aide les visiteurs à comprendre rapidement l’objectif du projet et comment l’exécuter localement [web:70][web:73].

## Aperçu

ViserMart Backoffice est une application d’administration conçue pour piloter les opérations d’un e-commerce depuis une interface web centralisée. Le projet couvre notamment :

## Stack

| Layer       | Technology                        |
|-------------|-----------------------------------|
| Framework   | Laravel 12 (PHP 8.3+)            |
| Database    | MySQL 8 / MariaDB 10.6+          |
| Frontend    | Blade + Tailwind CSS v4           |
| Assets      | Vite                              |
| Auth        | Custom admin guard (session)      |
| PDF         | barryvdh/laravel-dompdf           |
| Images      | Intervention Image v4             |
| Excel       | Maatwebsite Excel                 |
| API auth    | Laravel Sanctum                   |

- Authentification administrateur
- Gestion du catalogue produits
- Gestion des catégories et marques
- Gestion des commandes
- Gestion des paiements et dépôts
- Gestion des utilisateurs
- Gestion des promotions
- Gestion des tickets support
- Paramètres système
- Système multilingue

## Features

- Admin authentication with session-based guard
- Product management (CRUD, variants, stock tracking, import/export)
- Category & brand management (tree structure, soft delete)
- Order management (status workflow, invoicing)
- Payment gateway configuration (automatic & manual)
- Deposit tracking & approval
- Coupon & promotional offer system
- Shipping method management
- Support ticket system
- Notification system (email, SMS, push templates)
- CMS: page builder, menu builder, promotional banners
- User management (ban, verify, notify)
- SEO settings, sitemap, robots.txt
- Multi-language support
- Reports (sales, login history, notifications)
- System info & maintenance mode

## Stack technique

- **Framework** : Laravel 12
- **Langage** : PHP 8.4+
- **Base de données** : MySQL
- **Frontend admin** : Blade, JavaScript, CSS
- **Environnement local recommandé** : Laragon
- **Gestionnaire de dépendances PHP** : Composer
- **Assets frontend** : Node.js / NPM si recompilation nécessaire

## Fonctionnalités principales

- Tableau de bord administrateur
- Authentification admin sécurisée
- Gestion complète du catalogue
- Gestion des commandes et statuts
- Gestion des promotions et coupons
- Gestion des utilisateurs
- Gestion des langues
- Paramètres de configuration du site
- Système de notifications
- Gestion des pages frontend depuis l’admin

## État actuel du projet

Le backoffice admin est fonctionnel et les principales pages critiques ont été corrigées et validées. À ce stade :

- Connexion admin fonctionnelle
- Dashboard fonctionnel
- Pages admin principales accessibles
- Langue française ajoutée
- Optimisations de performance de base appliquées
- Plusieurs routes corrigées pour permettre la mise en cache Laravel


## Requirements

- PHP 8.3+
- Composer 2+
- MySQL 8.0+ or MariaDB 10.6+
- Node.js 18+ & npm (for Vite assets)
- GD or Imagick PHP extension

## Installation

```bash
git clone https://github.com/BambaDev/EtsMory_Backoffice.git
cd EtsMory_Backoffice

composer install
npm install --ignore-scripts

cp .env.example .env
php artisan key:generate
```

### Database setup

Create the database and import the schema:

```bash
mysql -u root -e "CREATE DATABASE visermart_backoffice CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root visermart_backoffice < database/schema/install.sql
```

> **Note:** This project uses a pre-built SQL schema, not Laravel migrations. Do **not** run `php artisan migrate`.

### Storage & assets

```bash
php artisan storage:link
npm run build
```

## Configuration

Copy `.env.example` to `.env` and adjust:

```dotenv
APP_NAME=ViserMart
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visermart_backoffice
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=database
QUEUE_CONNECTION=database
```

For email/SMS notifications, configure the appropriate `MAIL_*` and SMS provider keys.

## Running locally

```bash
# All services (server + queue + logs + vite)
composer dev

# Or individually
php artisan serve
npm run dev
```

Admin panel: [http://localhost:8000/admin](http://localhost:8000/admin)

### Default admin credentials

| Field    | Value            |
|----------|------------------|
| Username | `admin`          |
| Password | `admin123`       |

## Useful commands

```bash
# Clear all caches
php artisan optimize:clear

# Code formatting
./vendor/bin/pint

# Run tests
php artisan test

# Queue worker
php artisan queue:listen
```

## Project structure

```
app/
  Constants/          Status enums (Order, Payment, etc.)
  Http/
    Controllers/
      Admin/          36 admin controllers
      User/           User-facing controllers
    Helpers/          Global helper functions
    Middleware/       Auth guards, module checks
  Models/             51 Eloquent models
  Notify/             Notification channels
  Providers/          Service providers
  Services/           Business logic
  Traits/             Searchable, DateFilter, etc.
  Rules/              Custom validation rules
routes/
  admin.php           Admin routes (~270 routes)
  web.php             Public/frontend routes
  user.php            Authenticated user routes
  api.php             API routes
  ipn.php             Payment IPN callbacks
resources/views/
  admin/              Admin Blade templates (286 views)
public/assets/
  admin/              Admin CSS/JS
  global/             Shared assets
  images/             Static images
  font/               Web fonts
```

## Project status

| Module                  | Status  |
|-------------------------|---------|
| Admin auth & login      | Done    |
| Dashboard               | Done    |
| Products CRUD           | Done    |
| Categories & Brands     | Done    |
| Orders management       | Done    |
| Deposits & Payments     | Done    |
| Support tickets         | Done    |
| Users management        | Done    |
| Notifications settings  | Done    |
| CMS & Page builder      | Done    |
| System settings         | Done    |
| Reports                 | Done    |
| Frontend (user-facing)  | WIP     |
| Mobile app (Flutter)    | Planned |

**78 admin pages tested and functional.**

## Security

- Never commit `.env` or any file containing secrets
- The `.gitignore` excludes `.env`, `vendor/`, `node_modules/`, and storage keys
- Admin passwords are bcrypt-hashed
- CSRF protection is active on all POST routes

## License

MIT
