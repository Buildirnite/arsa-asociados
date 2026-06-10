# Capturas responsive (Playwright)

Genera capturas de pantalla de las vistas clave del panel y del blog en tres
anchos (móvil 390px, tablet 820px, escritorio 1366px) para revisar el diseño
responsive a ojo.

## Por qué corre dentro del contenedor

En WSL2 el host no tiene las librerías de sistema de Chromium (`libnspr4`, etc.)
y no hay `sudo` sin contraseña. El contenedor Sail (`arsa-asociados-laravel.test-1`)
sí las tiene (se instalaron con `playwright install --with-deps`) y además sirve
la app en `http://localhost:80`, así que Playwright se ejecuta **desde el contenedor**.

Instalación del navegador (una sola vez):

```bash
docker exec -u root arsa-asociados-laravel.test-1 \
  bash -c 'cd /var/www/html && npx playwright install --with-deps chromium'
```

## Cómo correrlo

1. Sembrar un artículo de demostración (publicado, con imagen y secciones) y
   quedarte con su ID:

   ```bash
   docker exec arsa-asociados-laravel.test-1 bash -c '
     mkdir -p storage/app/public/posts
     cp public/images/team/abogada.webp storage/app/public/posts/mobile-demo.webp'

   POST_ID=$(docker exec arsa-asociados-laravel.test-1 php artisan tinker --execute='
     echo App\Models\Post::updateOrCreate(
       ["slug" => "demo-mobile-responsive"],
       ["title"=>"Pensión de alimentos: guía práctica","category"=>"Derecho de Familia",
        "excerpt"=>"Resumen de ejemplo.","content"=>"<h2>Uno</h2><p>x</p><h2>Dos</h2><p>y</p>",
        "image"=>"posts/mobile-demo.webp","published_at"=>now()->subDay()]
     )->id;' | tail -1)
   ```

2. Lanzar las capturas (la contraseña sale de tu `.env`):

   ```bash
   docker exec -e POST_ID=$POST_ID -e ADMIN_PASSWORD="$(grep ^ADMIN_PASSWORD .env | cut -d= -f2-)" \
     arsa-asociados-laravel.test-1 bash -c 'cd /var/www/html && npx playwright test'
   ```

3. Las imágenes quedan en `tests/e2e/screenshots/<viewport>--<vista>.png`.
   Si las creó root, corregir dueño:

   ```bash
   docker exec -u root arsa-asociados-laravel.test-1 \
     chown -R 1000:1000 /var/www/html/tests/e2e
   ```

## Vistas capturadas

`admin-index`, `admin-create`, `admin-edit` (con imagen), `admin-preview`
(vista previa = `blog.show`) y `blog-index`.

> Las capturas y la sesión (`.auth/`) están en `.gitignore`; sólo se versiona el setup.
