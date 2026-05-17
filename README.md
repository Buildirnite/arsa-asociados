# Arsa & Asociados — Sitio Web Institucional

Sitio web institucional del estudio jurídico **Arsa & Asociados**, desarrollado con Laravel 12. Incluye página de inicio, blog público con SEO completo y un panel de administración para gestionar artículos y mensajes de contacto.

---

## Stack tecnológico

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.2+ / Laravel 12 |
| Frontend | Blade + Tailwind CSS v4 + Vite 7 |
| Editor | TipTap v2 (WYSIWYG) |
| Base de datos | MySQL 8.4 |
| Caché / Sesiones | Redis |
| Entorno local | Docker (Laravel Sail) |
| Despliegue | Railway (Nixpacks) |

---

## Funcionalidades

### Sitio público
- Homepage con 6 secciones: Hero, Servicios, Nosotros, Cómo trabajamos, Testimonios y Contacto
- Blog con listado paginado, búsqueda por texto y filtros por categoría
- Vista de artículo individual con tiempo de lectura estimado
- Formulario de contacto con rate limiting (3 envíos/min por IP) y guardado en base de datos
- Páginas legales: política de privacidad y términos de uso
- Sitemap XML generado dinámicamente (`/sitemap.xml`)

### SEO
- Meta tags, Open Graph y Twitter Card dinámicos
- JSON-LD global (`LegalService`) y por artículo (`BlogPosting`)
- Campos SEO editables por artículo (`meta_title`, `meta_description`, `slug`)

### Panel de administración (`/admin`)
- CRUD completo de artículos con editor WYSIWYG
- Imágenes destacadas por artículo (subida, preview, reemplazo y eliminación)
- Publicación programada (borrador, inmediata o futura)
- Vista previa de borradores antes de publicar
- Exportación CSV compatible con Excel
- Bandeja de mensajes de contacto con estado leído/no leído
- Autenticación por contraseña con rate limiting (5 intentos fallidos → bloqueo 60 s)

---

## Instalación local

### Requisitos
- Docker Desktop
- Composer
- Node.js 20+

### Pasos

```bash
git clone <url-del-repositorio>
cd arsa-asociados

# Copiar variables de entorno
cp .env.example .env

# Instalar dependencias PHP
composer install

# Levantar los contenedores
./vendor/bin/sail up -d

# Generar clave de aplicación
./vendor/bin/sail artisan key:generate

# Ejecutar migraciones
./vendor/bin/sail artisan migrate

# Instalar dependencias JS y compilar assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

Abrir `http://localhost` en el navegador.

---

## Variables de entorno relevantes

| Variable | Descripción |
|---|---|
| `APP_URL` | URL pública de la aplicación |
| `ADMIN_PASSWORD` | Contraseña del panel de administración |
| `DB_*` | Credenciales de MySQL |
| `MAIL_*` | Configuración SMTP para el formulario de contacto |
| `SESSION_ENCRYPT` | `true` en producción |
| `SESSION_SECURE_COOKIE` | `true` en producción |

Generar una contraseña segura para el admin:
```bash
openssl rand -base64 32
```

---

## Despliegue en Railway

El proyecto incluye `railway.toml` preconfigurado. Al hacer push, Railway:

1. Detecta el proyecto con Nixpacks
2. Ejecuta migraciones, cachea configuración y rutas
3. Levanta el servidor PHP en el puerto asignado

Configurar en Railway las mismas variables de entorno del `.env.example`, con `APP_ENV=production` y `APP_DEBUG=false`.

---

## URLs del sistema

| URL | Descripción |
|---|---|
| `/` | Página de inicio |
| `/blog` | Listado de artículos |
| `/blog/{slug}` | Artículo individual |
| `/contacto` (POST) | Formulario de contacto |
| `/sitemap.xml` | Sitemap para buscadores |
| `/admin` | Panel de administración |
| `/admin/mensajes` | Mensajes de contacto recibidos |

---

## Comandos frecuentes (con Sail)

```bash
# Levantar entorno
./vendor/bin/sail up -d

# Compilar assets en modo desarrollo
./vendor/bin/sail npm run dev

# Compilar para producción
./vendor/bin/sail npm run build

# Limpiar caché de vistas tras cambios en Blade
./vendor/bin/sail artisan view:clear

# Ejecutar tests
./vendor/bin/sail artisan test
```

---

## Documentación técnica

La carpeta `docs/` contiene documentación detallada del proyecto:

| Archivo | Contenido |
|---|---|
| [docs/entorno.md](./docs/entorno.md) | Stack, Docker, variables de entorno |
| [docs/arquitectura.md](./docs/arquitectura.md) | Rutas, controladores, modelos, middleware |
| [docs/base-de-datos.md](./docs/base-de-datos.md) | Esquema de tablas y migraciones |
| [docs/frontend.md](./docs/frontend.md) | Sistema de diseño, vistas Blade, editor TipTap |
| [docs/seo.md](./docs/seo.md) | Meta tags, Open Graph, JSON-LD |
| [docs/seguridad.md](./docs/seguridad.md) | Autenticación, protecciones, checklist de despliegue |
| [docs/troubleshooting.md](./docs/troubleshooting.md) | Bugs resueltos y decisiones técnicas |
| [docs/deploy-railway.md](./docs/deploy-railway.md) | Guía completa de despliegue en Railway |
