# Arsa & Asociados

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP_8.2+-777BB4?style=flat&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS_v4-38B2AC?style=flat&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=flat&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white)

Sitio web institucional para el estudio jurídico **Arsa & Asociados**. Incluye homepage completa, blog con SEO profesional y un panel de administración para gestionar artículos y mensajes de contacto.

## ¿Qué problema resuelve?

Un estudio jurídico necesita presencia digital profesional que transmita confianza y les permita publicar contenido sin depender de un desarrollador. Arsa & Asociados cubre ese flujo completo: homepage informativa, blog gestionado desde un panel propio con editor visual, formulario de contacto con protección contra spam y SEO listo para buscadores.

## Stack

| Capa | Tecnología |
|------|-----------|
| Backend | Laravel 12 · PHP 8.2+ |
| Frontend | Blade · Tailwind CSS v4 · Vite 7 |
| Editor | TipTap v2 (WYSIWYG) |
| Base de datos | MySQL 8.4 |
| Caché / Sesiones | Redis |
| Infraestructura | Docker · Laravel Sail |
| Despliegue | Por definir |

## Funcionalidades

**Sitio público**
- Homepage con 6 secciones: Hero, Servicios, Nosotros, Cómo trabajamos, Testimonios y Contacto
- Blog con listado paginado, búsqueda por texto y filtros por categoría
- Vista de artículo individual con tiempo de lectura estimado
- Formulario de contacto con rate limiting (3 envíos/min por IP) y guardado en base de datos
- Páginas legales: política de privacidad y términos de uso
- Sitemap XML generado dinámicamente

**Panel de administración (`/admin`)**
- CRUD completo de artículos con editor WYSIWYG (TipTap v2)
- Imágenes destacadas por artículo: subida, preview, reemplazo y eliminación
- Publicación programada: borrador, inmediata o futura (campo datetime)
- Vista previa de borradores antes de publicar
- Exportación CSV compatible con Excel con estado Publicado/Programado/Borrador
- Bandeja de mensajes de contacto con estado leído/no leído
- Autenticación por contraseña con rate limiting (5 intentos → bloqueo 60 s)

**SEO**
- Meta tags, Open Graph y Twitter Card dinámicos
- JSON-LD global (`LegalService`) y por artículo (`BlogPosting`)
- Campos SEO editables por artículo: `meta_title`, `meta_description`, `slug`
- Slugs con unicidad garantizada automáticamente

## Arquitectura

```
arsa-asociados/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── PostAdminController.php        # CRUD artículos + export + upload imagen
│   │   │   │   └── ContactMessageAdminController.php  # Bandeja de mensajes
│   │   │   ├── PostController.php                 # Blog público
│   │   │   └── ContactController.php              # Formulario de contacto
│   │   └── Middleware/
│   │       └── AdminPassword.php                  # Auth por contraseña con rate limiting
│   └── Models/
│       ├── Post.php                               # Scopes: published, scheduled, draft
│       └── ContactMessage.php
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php                      # Homepage (6 secciones)
│   │   ├── blog/                                  # index + show
│   │   ├── admin/                                 # login + posts + mensajes
│   │   ├── components/layout.blade.php            # Layout compartido con SEO
│   │   └── emails/contact.blade.php               # Notificación de contacto
│   ├── css/app.css                                # Paleta midnight + gold, fuentes
│   └── js/editor.js                               # TipTap con toolbar + subida inline
├── routes/web.php
└── docs/                                          # Documentación técnica completa
```

## Decisiones técnicas

**Autenticación por contraseña sin users table:** El panel admin no necesita un sistema de usuarios completo. Un middleware que compara la contraseña hasheada de `.env` con `Hash::check()` es suficiente y elimina toda la complejidad de registro, recuperación de cuenta y roles. El rate limiting de 5 intentos se implementa con el facade `RateLimiter` de Laravel, que ya maneja esto nativamente.

**TipTap v2 sobre otras opciones:** TipTap v2 es la única versión compatible con Vite 7 en el momento del desarrollo. v3 rompe el build. Ofrece extensiones oficiales para imágenes, links y estilos, y permite personalizar la toolbar completamente sin configuración adicional.

**Slugs únicos con sufijo numérico:** El método `uniqueSlug()` en `PostAdminController` verifica si el slug ya existe en la base de datos y agrega un sufijo incremental (`-2`, `-3`…) antes de guardar. Evita errores de unicidad en BD cuando dos artículos tienen el mismo título sin intervención del usuario.

**Rutas de acción antes de `Route::resource()`:** Las rutas `export`, `upload-image`, `destroyImage` y `preview` se declaran antes del resource para evitar que Laravel las trate como parámetros `{post}`. El orden importa en el router de Laravel.

**JSON-LD con `@@context` en Blade:** Las directivas `@json` de Blade interpretan `@` como directivas. Se usa `@@context` y `@@type` para que Blade los renderice como `@context` y `@type` en el HTML final, manteniendo el schema.org válido.

**`config()` en lugar de `env()` en controladores:** Cuando se cachea la configuración (`php artisan config:cache`), `env()` siempre devuelve `null`. Todo acceso a variables de entorno en controladores pasa por `config()`, que lee del caché.

## Rutas

| Método | Ruta | Descripción |
|--------|------|-------------|
| `GET` | `/` | Homepage |
| `GET` | `/blog` | Listado de artículos |
| `GET` | `/blog/{slug}` | Artículo individual |
| `POST` | `/contacto` | Formulario de contacto |
| `GET` | `/sitemap.xml` | Sitemap para buscadores |
| `GET` | `/admin` | Panel de administración |
| `GET` | `/admin/posts` | Listado de artículos (admin) |
| `GET` | `/admin/posts/export` | Exportar CSV |
| `POST` | `/admin/upload-image` | Subida de imagen inline (TipTap) |
| `GET` | `/admin/mensajes` | Bandeja de mensajes de contacto |

## Instalación

### Requisitos

- Docker Desktop
- Composer 2+
- Node.js 20+

### Pasos

```bash
git clone https://github.com/Buildirnite/arsa-asociados.git
cd arsa-asociados

# Variables de entorno
cp .env.example .env

# Dependencias PHP
composer install

# Levantar contenedores
./vendor/bin/sail up -d

# Clave de aplicación
./vendor/bin/sail artisan key:generate

# Migraciones
./vendor/bin/sail artisan migrate

# Dependencias JS y assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

Abrir `http://localhost` para el sitio y `http://localhost/admin` para el panel.

**Variables de entorno clave:**

```env
ADMIN_PASSWORD=contraseña-robusta
MAIL_HOST=smtp.ejemplo.com
MAIL_USERNAME=correo@ejemplo.com
MAIL_PASSWORD=contraseña
MAIL_FROM_ADDRESS=catalynaarmas@gmail.com
```

Generar contraseña segura para el admin:
```bash
openssl rand -base64 32
```

## Autor

**Buildirnite** · [github.com/Buildirnite](https://github.com/Buildirnite)
