# Base de datos

## Tabla `posts`

| Columna | Tipo | Restricciones | Descripción |
|---|---|---|---|
| `id` | `bigint unsigned` | PK, auto-increment | |
| `title` | `varchar(255)` | NOT NULL | Título del artículo |
| `slug` | `varchar(255)` | UNIQUE, NOT NULL | URL amigable (`/blog/{slug}`) |
| `meta_title` | `varchar(70)` | nullable | Título para Google (SEO) |
| `meta_description` | `varchar(160)` | nullable | Descripción para Google (SEO) |
| `excerpt` | `varchar(300)` | NOT NULL | Resumen visible en el listado del blog |
| `content` | `longtext` | NOT NULL | HTML generado por el editor TipTap |
| `category` | `varchar(255)` | NOT NULL, default `General` | Categoría del artículo |
| `image` | `varchar(255)` | nullable | Ruta relativa de la imagen destacada en disco `public` |
| `published_at` | `timestamp` | nullable | `NULL` = borrador; pasada = publicado; futura = programado |
| `created_at` | `timestamp` | | Automático de Laravel |
| `updated_at` | `timestamp` | | Automático de Laravel |

---

## Tabla `contact_messages`

| Columna | Tipo | Restricciones | Descripción |
|---|---|---|---|
| `id` | `bigint unsigned` | PK, auto-increment | |
| `name` | `varchar(100)` | NOT NULL | Nombre del remitente |
| `email` | `varchar(150)` | NOT NULL | Email del remitente |
| `phone` | `varchar(20)` | nullable | Teléfono del remitente |
| `message` | `text` | NOT NULL | Contenido del mensaje |
| `read_at` | `timestamp` | nullable | `NULL` = no leído; con fecha = leído |
| `created_at` | `timestamp` | | Automático de Laravel |
| `updated_at` | `timestamp` | | Automático de Laravel |

---

## Categorías disponibles (posts)

Definidas en el formulario del panel admin:

- Derecho Civil
- Derecho Laboral
- Derecho de Familia
- Derecho Inmobiliario
- Cobranza Judicial
- Derecho Penal
- General

---

## Migraciones

| Archivo | Qué hace |
|---|---|
| `2026_03_16_000001_create_posts_table.php` | Crea la tabla `posts` con campos base |
| `2026_03_17_032650_add_image_to_posts_table.php` | Agrega columna `image` |
| `2026_03_17_100000_add_seo_fields_to_posts_table.php` | Agrega `meta_title` y `meta_description` |
| `2026_03_17_210000_create_contact_messages_table.php` | Crea la tabla `contact_messages` |

### Ejecutar migraciones

```bash
docker exec arsa-asociados-laravel.test-1 php artisan migrate
```
