# Luxe Burger

A complete restaurant web experience built with **Laravel 9** and **Three.js** — featuring an interactive 3D burger scene, an online menu with delivery ordering, table reservations, customer reviews, and a full admin dashboard.

## Features

### Public website
- Immersive landing page with a real-time **3D burger model** (Three.js / GLB)
- Full menu organized by category with quick-view modals, ingredient lists, and allergen tags
- **AJAX delivery ordering** flow with quantity selection
- Table **reservation** form with date and party-size validation
- **Contact** form with message persistence
- Customer **reviews** with star ratings

### Admin panel
- Secure login (Laravel authentication + session management)
- Menu items **CRUD** (create, edit, delete)
- Reservations tracking with status updates
- Messages inbox with read/unread state

## Tech stack

- [Laravel 9](https://laravel.com) — PHP 8
- MySQL
- Blade templates + Bootstrap 5 (dark theme)
- [Three.js](https://threejs.org) — 3D scene
- esbuild + Laravel Mix — asset bundling

## Getting started

### Requirements

- PHP >= 8.0
- Composer
- MySQL
- Node.js (for front-end assets)

### Installation

1. Clone the repository and install the dependencies:

   ```bash
   composer install
   npm install
   ```

2. Set up the environment file:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure the database connection in `.env`, then run the migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

4. Build the front-end assets:

   ```bash
   npm run prod
   ```

5. Serve the application:

   ```bash
   php artisan serve
   ```

6. Create an admin account:

   ```bash
   php artisan tinker
   User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('secret')]);
   ```

## Routes

### Public

| Route | Description |
| ----- | ----------- |
| `/` | Home page (3D hero, specials, reviews) |
| `/menu` | Restaurant menu |
| `/reservation` | Book a table |
| `/contact` | Contact form |

### Admin (requires authentication)

| Route | Description |
| ----- | ----------- |
| `/admin` | Dashboard |
| `/admin/menu-items` | Manage menu items |
| `/admin/reservations` | Manage reservations |
| `/admin/messages` | Messages inbox |
| `/admin/login` | Sign in |

## Project structure

| Path | Purpose |
| ---- | ------- |
| `app/Http/Controllers/PublicController.php` | Public site logic |
| `app/Http/Controllers/AdminController.php` | Admin panel logic |
| `app/Models` | Eloquent models (`MenuItem`, `Reservation`, `Message`, `Order`, `FoodReview`, `User`) |
| `resources/views` | Blade templates |
| `database/migrations` | Database schema |
| `database/seeders/DatabaseSeeder.php` | Demo menu data |
| `public/models/burger.glb` | 3D burger model |

## License

This project is open-sourced under the [MIT license](LICENSE).