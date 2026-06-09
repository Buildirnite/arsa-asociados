# Entorno de desarrollo

## Stack

| Capa | Tecnología |
|---|---|
| Backend | Laravel 12 (PHP 8.5 en Docker) |
| Frontend build | Vite 7 + `laravel-vite-plugin` |
| CSS | Tailwind CSS v4 (CSS-first, sin `tailwind.config.js`) |
| Plugin tipografía | `@tailwindcss/typography` |
| Editor de contenido | TipTap v2 |
| Base de datos | MySQL 8.4 |
| Cache / sesiones | Redis (alpine) |
| Contenedor | Docker — Laravel Sail |
| Fuentes | Inter + Playfair Display (Google Fonts) |

---

## Docker

El proyecto corre en **Laravel Sail**. El contenedor PHP se llama `arsa-asociados-laravel.test-1`.

> La CLI del host tiene **PHP 8.3** y el servidor corre **PHP 8.5**. Todos los comandos `artisan` y `npm` deben ejecutarse dentro del contenedor para evitar incompatibilidades.

```bash
# Artisan
docker exec arsa-asociados-laravel.test-1 php artisan <comando>

# NPM
docker exec arsa-asociados-laravel.test-1 npm install <paquete>
```

### Levantar el entorno

```bash
./vendor/bin/sail up -d
./vendor/bin/sail npm run dev    # Vite en modo watch
```

---

## Variables de entorno (`.env`)

```env
APP_URL=http://localhost
APP_ADMIN_PASSWORD=<contraseña-del-panel>

FILESYSTEM_DISK=public

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=arsa
DB_USERNAME=sail
DB_PASSWORD=password

MAIL_MAILER=smtp
MAIL_FROM_ADDRESS=catalynaarmas@gmail.com
MAIL_FROM_NAME="Arsa & Asociados"
```

`APP_ADMIN_PASSWORD` es leída por `config('app.admin_password')` y usada por el middleware `AdminPassword`.

---

## Comandos frecuentes

```bash
# Levantar / detener entorno
./vendor/bin/sail up -d
./vendor/bin/sail down

# Vite
./vendor/bin/sail npm run dev       # modo watch (desarrollo)
./vendor/bin/sail npm run build     # build de producción

# Artisan
docker exec arsa-asociados-laravel.test-1 php artisan migrate
docker exec arsa-asociados-laravel.test-1 php artisan view:clear    # obligatorio tras cambios en Blade
docker exec arsa-asociados-laravel.test-1 php artisan cache:clear
docker exec arsa-asociados-laravel.test-1 php artisan storage:link  # symlink de imágenes

# NPM dentro del contenedor
docker exec arsa-asociados-laravel.test-1 npm install <paquete> --save-dev
```
