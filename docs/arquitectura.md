# Arquitectura

## Estructura de carpetas

```
arsa-asociados/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── PostAdminController.php           # CRUD posts + upload imágenes + export CSV
│   │   │   │   └── ContactMessageAdminController.php # Lista y gestión de mensajes de contacto
│   │   │   ├── ContactController.php                 # Formulario de contacto (guarda en BD + envía email)
│   │   │   └── PostController.php                    # Blog público (con búsqueda y filtros)
│   │   └── Middleware/
│   │       └── AdminPassword.php                     # Autenticación por contraseña de sesión
│   └── Models/
│       ├── Post.php
│       └── ContactMessage.php
├── database/
│   └── migrations/
├── public/
│   └── images/
│       ├── logo.png          # Logo completo — navbar
│       └── logo-icon.png     # Solo el escudo — footer, admin, favicon
├── resources/
│   ├── css/app.css           # Tailwind v4 + paleta custom + plugin typography
│   ├── js/
│   │   ├── app.js
│   │   └── editor.js         # TipTap WYSIWYG
│   └── views/
│       ├── components/
│       │   └── layout.blade.php     # Layout global (navbar, footer, SEO, WhatsApp)
│       ├── welcome.blade.php        # Homepage
│       ├── blog/
│       │   ├── index.blade.php      # Listado con búsqueda y filtros de categoría
│       │   └── show.blade.php       # Vista individual con JSON-LD BlogPosting
│       ├── admin/
│       │   ├── login.blade.php
│       │   ├── posts/
│       │   │   ├── index.blade.php  # Listado con nav a mensajes
│       │   │   └── form.blade.php   # Crear/editar post
│       │   └── mensajes/
│       │       └── index.blade.php  # Bandeja de mensajes de contacto
│       ├── emails/
│       ├── legal/
│       └── sitemap.blade.php
├── routes/
│   └── web.php
└── vite.config.js
```

---

## Rutas (`routes/web.php`)

```
GET  /                              → welcome.blade.php
POST /contacto                      → ContactController@store  [throttle: 3/min]
GET  /sitemap.xml                   → Genera XML con todos los posts publicados
GET  /politica-de-privacidad        → legal.privacy
GET  /terminos-de-uso               → legal.terms

GET  /blog                          → PostController@index  [?buscar= &categoria=]
GET  /blog/{slug}                   → PostController@show

GET  /admin                         → redirige a admin.posts.index  [middleware: AdminPassword]
POST /admin                         → redirige a admin.posts.index  [manejo del login]
POST /admin/upload-image            → PostAdminController@uploadImage
GET  /admin/posts/export            → PostAdminController@export
DELETE /admin/posts/{post}/image    → PostAdminController@destroyImage
GET  /admin/posts/{post}/preview    → PostAdminController@preview
GET  /admin/posts                   → PostAdminController@index
GET  /admin/posts/create            → PostAdminController@create
POST /admin/posts                   → PostAdminController@store
GET  /admin/posts/{id}/edit         → PostAdminController@edit
PUT  /admin/posts/{id}              → PostAdminController@update
DELETE /admin/posts/{id}            → PostAdminController@destroy

GET  /admin/mensajes                → ContactMessageAdminController@index
PATCH /admin/mensajes/{id}/leer    → ContactMessageAdminController@markRead
```

> **Importante:** las rutas especiales (`export`, `destroyImage`, `preview`) se declaran **antes** de `Route::resource()` para evitar que Laravel las interprete como el parámetro `{post}`.

---

## Controladores

### `PostController` — blog público

| Método | Acción |
|---|---|
| `index(Request $request)` | Lista posts publicados con filtros opcionales `?buscar=` y `?categoria=`. 9 por página, la paginación conserva los query params |
| `show(string $slug)` | Muestra un artículo. Carga hasta 3 relacionados (misma categoría) |

### `PostAdminController` — panel admin

| Método | Acción |
|---|---|
| `index()` | Lista todos los artículos (publicados, programados y borradores), 15 por página |
| `create()` | Muestra el formulario vacío |
| `store()` | Valida (incluye unicidad del slug), resuelve `publish_at`, guarda imagen si se adjuntó, crea el post |
| `edit(Post $post)` | Muestra el formulario con datos del post |
| `update()` | Valida, actualiza slug si se editó, reemplaza imagen si se adjuntó, actualiza `published_at` |
| `destroy(Post $post)` | Elimina el post y su imagen del disco |
| `destroyImage(Post $post)` | Elimina solo la imagen destacada (archivo + `image = null`), el post queda intacto |
| `preview(Post $post)` | Renderiza `blog/show.blade.php` con datos actuales (funciona con borradores) |
| `uploadImage()` | Recibe imagen del editor TipTap, devuelve `{ url }` |
| `export()` | Descarga CSV con todos los artículos (UTF-8 BOM para Excel, incluye estado Programado) |

**Lógica de slug:**
- `store`: si el campo `slug` viene lleno se usa; si no, se genera desde el título con `Str::slug()`.
- `update`: si se editó se aplica `Str::slug()` al valor; si viene vacío se conserva el slug actual.
- En ambos casos el slug pasa por `uniqueSlug()` antes de guardarse.

**`uniqueSlug(string $base, ?int $ignoreId = null)`** — método privado que garantiza unicidad:
- Consulta la BD. Si `$base` ya existe → intenta `$base-2`, `$base-3`, etc. hasta encontrar uno libre.
- `$ignoreId` excluye el propio post en `update` (para que no colisione consigo mismo).
- Ejemplo: si `derecho-civil` ya existe, asigna `derecho-civil-2` automáticamente sin error.

**Lógica de `published_at`:**
- El formulario usa `<input type="datetime-local" name="publish_at">`.
- Vacío → `null` (borrador).
- Fecha pasada → publica de inmediato.
- Fecha futura → publicación programada (aparecerá en el blog cuando llegue esa hora).
- El `scopePublished()` del modelo filtra `published_at <= NOW()` automáticamente.

### `ContactMessageAdminController` — mensajes

| Método | Acción |
|---|---|
| `index()` | Lista todos los mensajes ordenados por fecha DESC. Pasa también el conteo de no leídos (`$unread`) |
| `markRead(ContactMessage $message)` | Setea `read_at = now()` si no estaba leído |

### `ContactController`

Valida el formulario, guarda en `contact_messages` (primero), luego envía email a `contacto@arsayasociados.cl`. Si el email falla, el mensaje ya está guardado en BD.

---

## Modelo `Post`

```php
protected $fillable = [
    'title', 'slug', 'excerpt', 'content', 'category',
    'image', 'meta_title', 'meta_description', 'published_at'
];

protected $casts = ['published_at' => 'datetime'];
```

| Scope / Método | Descripción |
|---|---|
| `scopePublished()` | Filtra posts con `published_at NOT NULL` y `published_at <= NOW()` |
| `isPublished(): bool` | `true` si el post ya es visible públicamente |
| `isScheduled(): bool` | `true` si tiene `published_at` en el futuro |
| `readingTime(): int` | Estima minutos de lectura: `ceil(palabras / 200)`, mínimo 1 |

---

## Modelo `ContactMessage`

```php
protected $fillable = ['name', 'email', 'phone', 'message', 'read_at'];
protected $casts    = ['read_at' => 'datetime'];
```

| Método | Descripción |
|---|---|
| `isRead(): bool` | `true` si `read_at` no es `null` |

---

## Middleware `AdminPassword`

Autenticación simple por contraseña de sesión. No usa el sistema de usuarios de Laravel.

**Flujo:**
1. Si la sesión tiene `admin_authenticated = true` → deja pasar.
2. Si es POST → verifica rate limit (clave `admin-login:{ip}`, máximo 5 intentos, ventana 60 seg).
3. Si superó el límite → HTTP 429 con mensaje de espera.
4. Si la contraseña coincide con `config('app.admin_password')` → limpia el contador, guarda en sesión, redirige.
5. Si la contraseña es incorrecta → incrementa el contador, muestra error en `admin.login`.
6. Cualquier otro caso (GET sin sesión) → muestra `admin.login`.

Ver detalles de seguridad en [seguridad.md](./seguridad.md).
