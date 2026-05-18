# Estructura de archivos — Arsa & Asociados

Stack: Laravel 12 · Vite 7 · Tailwind CSS v4 · MySQL 8.4 · Docker (Sail)

---

## Raíz del proyecto

| Archivo | Propósito |
|---|---|
| `.editorconfig` | Reglas de formato de código (indent, charset, trailing newline) |
| `.env` | Variables de entorno (DB, mail, app key, ADMIN_PASSWORD). **No subir a git.** |
| `.env.example` | Plantilla pública de variables de entorno |
| `artisan` | CLI de Laravel |
| `composer.json` | Dependencias PHP (Laravel 12, Sail, Pint) |
| `compose.yaml` | Configuración Docker Compose (Laravel Sail): contenedores PHP 8.5, MySQL 8.4, Redis |
| `package.json` | Dependencias JS (Vite, Tailwind v4, TipTap v2) |
| `phpunit.xml` | Configuración de PHPUnit: SQLite en memoria para tests, variables de entorno de prueba |
| `README.md` | Documentación principal del proyecto |
| `vite.config.js` | Configuración Vite 7: entradas `resources/css/app.css` + `resources/js/app.js` |

---

## app/

### Http/Controllers/

| Archivo | Ruta URL | Propósito |
|---|---|---|
| `Controller.php` | — | Controlador base de Laravel |
| `ContactController.php` | `POST /contacto` | Procesa el formulario de contacto, guarda en DB y envía email |
| `PostController.php` | `GET /blog`, `GET /blog/{slug}` | Muestra el listado y detalle de artículos del blog (público) |
| `Admin/ContactMessageAdminController.php` | `GET /admin/mensajes` | Lista y marca como leídos los mensajes de contacto recibidos |
| `Admin/PostAdminController.php` | `GET\|POST /admin/posts/*` | CRUD completo de posts: crear, editar, publicar, exportar, subir imágenes, preview |

### Http/Middleware/

| Archivo | Propósito |
|---|---|
| `AdminPassword.php` | Protege todas las rutas `/admin/*` con contraseña simple (variable `ADMIN_PASSWORD` en `.env`) |

### Models/

| Archivo | Tabla | Propósito |
|---|---|---|
| `ContactMessage.php` | `contact_messages` | Mensaje de contacto recibido desde el formulario público |
| `Post.php` | `posts` | Artículo de blog: título, slug, contenido HTML, imagen, SEO, fecha de publicación |
| `User.php` | `users` | Usuario (base de Laravel; no usado activamente en el sitio) |

### Providers/

| Archivo | Propósito |
|---|---|
| `AppServiceProvider.php` | Proveedor principal: configura paginación con Tailwind |

---

## bootstrap/

| Archivo | Propósito |
|---|---|
| `app.php` | Crea e inicializa la aplicación Laravel (middlewares globales, excepciones, rutas) |
| `providers.php` | Registro automático de proveedores de servicios |

---

## config/

Archivos de configuración de Laravel. Usar siempre `config()` en código, nunca `env()` directamente.

| Archivo | Propósito |
|---|---|
| `app.php` | Nombre de la app, URL, timezone, locale (`es`), claves de admin y contacto |
| `auth.php` | Guards y providers de autenticación |
| `cache.php` | Driver de caché (Redis en producción, array en tests) |
| `database.php` | Conexiones a MySQL y SQLite |
| `filesystems.php` | Discos de almacenamiento (local, public, s3 para Cloudflare R2) |
| `logging.php` | Canal de logs (stack, daily) |
| `mail.php` | Configuración del servidor de correo saliente |
| `queue.php` | Driver de colas (sync por defecto) |
| `services.php` | Credenciales de servicios externos |
| `session.php` | Driver de sesión, cifrado, cookie segura |

---

## database/

### factories/

| Archivo | Propósito |
|---|---|
| `PostFactory.php` | Factory de posts: estados `published()`, `draft()` y `scheduled()` para tests |
| `UserFactory.php` | Factory de usuarios (base de Laravel) |

### migrations/

Ordenadas cronológicamente por fecha de ejecución.

| Archivo | Propósito |
|---|---|
| `0001_01_01_000000_create_users_table.php` | Tabla `users` (base Laravel) |
| `0001_01_01_000001_create_cache_table.php` | Tabla `cache` para driver de caché en DB |
| `0001_01_01_000002_create_jobs_table.php` | Tabla `jobs` para colas |
| `2026_03_16_000001_create_posts_table.php` | Tabla `posts`: título, slug, excerpt, contenido, categoría, fechas |
| `2026_03_17_032650_add_image_to_posts_table.php` | Agrega columna `image` (nullable) a `posts` |
| `2026_03_17_100000_add_seo_fields_to_posts_table.php` | Agrega `meta_title` y `meta_description` a `posts` |
| `2026_03_17_210000_create_contact_messages_table.php` | Tabla `contact_messages`: nombre, email, teléfono, mensaje, `read_at` |

### seeders/

| Archivo | Propósito |
|---|---|
| `ContactMessageSeeder.php` | Inserta 4 mensajes de ejemplo (2 leídos, 2 sin leer, fechas distintas en los últimos 30 días) |
| `DatabaseSeeder.php` | Seeder principal: llama a `PostSeeder` y `ContactMessageSeeder` |
| `PostSeeder.php` | Inserta 5 posts de ejemplo con contenido jurídico chileno (2 publicados, 2 borradores, 1 programado) |

---

## docs/

Documentación técnica del proyecto. Empezar por `README.md`.

| Archivo | Propósito |
|---|---|
| `arquitectura.md` | Decisiones de arquitectura, stack y justificaciones técnicas |
| `base-de-datos.md` | Esquema de tablas, relaciones y migraciones |
| `entorno.md` | Configuración del entorno local con Docker/Sail |
| `estructura-archivos.md` | Este archivo — mapa completo de archivos y su propósito |
| `frontend.md` | Sistema de diseño, paleta de colores, fuentes y animaciones |
| `pendientes-y-auditoria.md` | Checklist de tareas pendientes antes de producción |
| `README.md` | Índice de la documentación y primeros pasos |
| `seguridad.md` | Medidas de seguridad implementadas (anti-scraping, CSRF, rate limiting, etc.) |
| `seo.md` | Estrategia SEO: meta tags, JSON-LD, sitemap, robots.txt |
| `troubleshooting.md` | Soluciones a problemas frecuentes del entorno y despliegue |

---

## public/

Directorio raíz del servidor web. Solo los archivos aquí son accesibles directamente.

| Archivo / Carpeta | Propósito |
|---|---|
| `.htaccess` | Reglas de Apache (rewrite a `index.php`) |
| `favicon.ico` | Favicon del sitio |
| `index.php` | Punto de entrada de Laravel |
| `robots.txt` | Directivas para rastreadores SEO |
| `build/` | Assets compilados por Vite (CSS + JS con hash de contenido) |
| `images/brand/logo-icon.png` | Solo el escudo (footer, admin, favicon) — altura `h-40` |
| `images/brand/logo.png` | Logo completo con texto (navbar) — altura `h-23` |
| `images/team/abogada.webp` | Foto de Nicool Armas (hero y sección nosotros) |
| `images/ui/telefono.webp` | Imagen del número de teléfono (anti-scraping, nunca texto plano) |
| `storage/` | Symlink a `storage/app/public/` generado por `php artisan storage:link` |

---

## resources/

### css/

| Archivo | Propósito |
|---|---|
| `app.css` | Hoja de estilos principal: importa Tailwind v4 y el plugin Typography, define paleta `midnight` y `gold` en `@theme`, fuentes Inter y Playfair Display, animaciones de scroll (`.reveal` + `.is-visible`), keyframes de figuras geométricas (`geo-f1` … `geo-f4`) |

### js/

| Archivo | Propósito |
|---|---|
| `animations.js` | Parallax de figuras geométricas por cursor (`mousemove` + `requestAnimationFrame`) e `IntersectionObserver` para animaciones de scroll bidireccionales (`.reveal`) |
| `app.js` | Punto de entrada JS: importa `bootstrap.js` y `animations.js` |
| `bootstrap.js` | Inicialización de Axios y utilidades base de Laravel |
| `editor.js` | Configuración del editor TipTap v2 para el admin del blog: barra de herramientas, subida de imágenes vía `/admin/upload-image` |

### views/

#### components/

| Archivo | Propósito |
|---|---|
| `layout.blade.php` | Layout global: `<head>` con SEO completo (meta, Open Graph, JSON-LD LocalBusiness), navbar sticky con indicador de sección activa por `IntersectionObserver`, footer con teléfono-imagen + redes sociales, botón flotante de WhatsApp |

#### admin/

| Archivo | URL | Propósito |
|---|---|---|
| `login.blade.php` | `GET /admin` | Formulario de acceso al panel (contraseña simple, muestra errores de autenticación) |
| `mensajes/index.blade.php` | `GET /admin/mensajes` | Bandeja de mensajes de contacto con estado leído/no leído y acción de marcar leído |
| `posts/form.blade.php` | `GET /admin/posts/create`, `GET /admin/posts/{id}/edit` | Formulario de creación/edición de post: editor TipTap, campos SEO, imagen destacada, fecha de publicación programada y vista previa |
| `posts/index.blade.php` | `GET /admin/posts` | Listado de todos los posts con estado (publicado, borrador, programado) y acciones (editar, eliminar, exportar) |

#### blog/

| Archivo | URL | Propósito |
|---|---|---|
| `index.blade.php` | `/blog` | Listado de artículos publicados con filtros por categoría y búsqueda, paginación |
| `show.blade.php` | `/blog/{slug}` | Artículo individual: contenido HTML, JSON-LD Article, imagen destacada, posts relacionados |

#### emails/

| Archivo | Propósito |
|---|---|
| `contact.blade.php` | Plantilla HTML del correo enviado al recibir un mensaje desde el formulario de contacto |

#### errors/

| Archivo | Propósito |
|---|---|
| `404.blade.php` | Página de error "Recurso no encontrado" con identidad visual del sitio |
| `500.blade.php` | Página de error "Error interno del servidor" con identidad visual del sitio |
| `503.blade.php` | Página de mantenimiento con identidad visual del sitio |

#### legal/

| Archivo | URL | Propósito |
|---|---|---|
| `privacy.blade.php` | `/politica-de-privacidad` | Política de privacidad |
| `terms.blade.php` | `/terminos-de-uso` | Términos de uso |

#### Raíz de views/

| Archivo | URL | Propósito |
|---|---|---|
| `sitemap.blade.php` | `/sitemap.xml` | Sitemap XML dinámico con todas las páginas estáticas y posts publicados |
| `welcome.blade.php` | `/` | Página principal: Hero (split crema/midnight + foto + estadísticas), Servicios, Nosotros, Nuestro proceso (timeline alternado), Testimonios, Contacto |

---

## routes/

| Archivo | Propósito |
|---|---|
| `console.php` | Comandos Artisan personalizados del proyecto |
| `web.php` | Todas las rutas HTTP: `/`, blog, admin (protegido con `AdminPassword`), contacto (con `throttle:3,1`), páginas legales, sitemap |

---

## storage/

| Carpeta | Propósito |
|---|---|
| `app/public/posts/` | Imágenes de portada subidas desde el admin (accesibles vía symlink `public/storage`) |
| `app/private/` | Archivos privados no accesibles públicamente |
| `framework/` | Caché de vistas compiladas, sesiones y caché de la app (generado por Laravel) |
| `logs/` | Archivos de log de Laravel (`laravel.log`) |

---

## tests/

| Archivo | Propósito |
|---|---|
| `TestCase.php` | Clase base: deshabilita CSRF (`ValidateCsrfToken`) globalmente en todos los tests |
| `Feature/AdminTest.php` | Tests del panel admin: acceso sin autenticación, login con contraseña correcta e incorrecta, rutas protegidas |
| `Feature/BlogTest.php` | Tests del blog público: índice, post publicado (200), borrador y programado (404), slug inexistente (404) |
| `Feature/ContactFormTest.php` | Tests del formulario de contacto: guardado en DB, validación de campos requeridos y email, rate limiting (429 al 4.º intento) |
| `Feature/ExampleTest.php` | Test de ejemplo de Laravel (respuesta 200 en `/`) |
| `Unit/ExampleTest.php` | Test de unidad de ejemplo de Laravel |
