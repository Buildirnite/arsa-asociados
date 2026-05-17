# Frontend

## Sistema de diseño

La configuración de Tailwind v4 es **CSS-first** — no existe `tailwind.config.js`. Todo vive en `resources/css/app.css`.

### Paleta `midnight` (azul marino institucional)

| Token | Hex |
|---|---|
| `midnight-50` | `#f4f6f9` |
| `midnight-100` | `#e2e7ef` |
| `midnight-200` | `#c9d1e1` |
| `midnight-300` | `#a4b1cb` |
| `midnight-400` | `#788db1` |
| `midnight-500` | `#586f99` |
| `midnight-600` | `#465980` |
| `midnight-700` | `#3b4968` |
| `midnight-800` | `#343f57` |
| `midnight-900` | `#1c2233` |
| `midnight-950` | `#121726` |

### Paleta `gold` (dorado institucional)

| Token | Hex |
|---|---|
| `gold-50` | `#faf8f0` |
| `gold-100` | `#f2edda` |
| `gold-200` | `#e5dab5` |
| `gold-300` | `#d4c088` |
| `gold-400` | `#c5a55e` |
| `gold-500` | `#b8923f` |
| `gold-600` | `#a07a34` |
| `gold-700` | `#7d5d2c` |
| `gold-800` | `#6a4e2b` |
| `gold-900` | `#5b4228` |

### Tipografía

| Rol | Fuente | Pesos |
|---|---|---|
| Sans-serif (cuerpo, UI) | Inter | 300, 400, 500, 600, 700 |
| Serif (títulos, headings) | Playfair Display | 400, 500, 600, 700 + itálicas |

Cargadas desde Google Fonts con `rel="preconnect"` para reducir latencia.

### Plugin Typography

Instalado como `@tailwindcss/typography`. Se usa siempre con la variante `prose-slate`.

> Usar `prose-slate`, **nunca** `prose-midnight` — esta variante no está definida en el plugin.

---

## Vistas Blade

### Layout global — `components/layout.blade.php`

Componente anónimo usado con la directiva `<x-layout>`.

**Props disponibles:**

| Prop | Default | Uso |
|---|---|---|
| `:title` | Título genérico del estudio | `<title>` y OG title |
| `:description` | Descripción genérica | `<meta name="description">` |
| `:canonical` | URL actual | `<link rel="canonical">` |
| `:ogImage` | `logo-icon.png` | `og:image` y Twitter card image |
| `ogType` | `website` | `og:type` — pasar `article` en páginas de artículo |

**Slot `headExtra`** — para inyectar contenido adicional en el `<head>`:

```blade
<x-layout ...>
    <x-slot:headExtra>
        <script type="application/ld+json">...</script>
    </x-slot:headExtra>
    contenido...
</x-layout>
```

**Contenido del layout:**
- Meta tags SEO (Open Graph, Twitter Card, canonical)
- JSON-LD `LegalService` (Schema.org) — en todas las páginas
- Slot `headExtra` — JSON-LD adicional u otros tags por página
- Favicon + Apple Touch Icon (`logo-icon.png`)
- Navbar sticky con logo, links de navegación y menú mobile
- `{{ $slot }}` — contenido de la página
- Footer 3 columnas (logo + escudo, navegación, datos de contacto)
- Botón flotante de WhatsApp

**Links de navegación:** todos los anchors usan prefijo `/` (ej. `/#servicios`) para funcionar desde cualquier página, no solo desde la home.

**Logos:**
- Navbar: `logo.png` (logo completo con texto) a `h-23`
- Footer: `logo-icon.png` (escudo) a `h-40`

---

### Homepage — `welcome.blade.php`

| # | Sección | ID | Fondo |
|---|---|---|---|
| 1 | Hero — H1 "Formación vigente. / Experiencia real.", 4 estadísticas | `#hero` | `midnight-950` |
| 2 | Servicios — 6 tarjetas de áreas de práctica | `#servicios` | `white` |
| 3 | Nosotros — grid 2 columnas, foto + texto | `#nosotros` | `midnight-50` |
| 4 | Cómo trabajamos — 3 pasos numerados (01 / 02 / 03) | `#como-trabajamos` | `midnight-950` |
| 5 | Testimonios — 3 `<figure>` con `<blockquote>` | `#testimonios` | `midnight-50` |
| 6 | Contacto — formulario funcional | `#contacto` | `white` |

---

### Blog público

**`blog/index.blade.php`**
- Barra de búsqueda por texto (`?buscar=`) + botón Buscar.
- Pills de categoría dinámicas (solo categorías con artículos publicados, `?categoria=`).
- Ambos filtros son combinables y la paginación los conserva con `appends(request()->query())`.
- Botón "Limpiar" visible solo cuando hay filtros activos.
- Mensaje diferenciado: "No se encontraron artículos" (con filtros) vs. "Próximamente..." (sin contenido).
- Grilla de tarjetas con thumbnail (efecto zoom al hover), categoría, título, excerpt, fecha y tiempo de lectura.
- Paginación de 9 artículos por página, ordenados por `published_at` DESC.

**`blog/show.blade.php`**
- `ogType="article"` y slot `headExtra` con JSON-LD `BlogPosting`.
- Header: categoría, título, autora (Nicool Armas), fecha de publicación, tiempo de lectura estimado.
- Imagen destacada a ancho completo (si existe).
- Contenido con clase `prose prose-slate prose-lg`.
- CTA para agendar consulta.
- Artículos relacionados (misma categoría, hasta 3).

---

### Panel admin

**`admin/login.blade.php`** — Formulario de contraseña con `logo-icon.png`.

**Navegación admin** — tabs en la parte superior de cada sección:
- "Artículos" → `/admin/posts`
- "Mensajes" → `/admin/mensajes` (con badge de no leídos cuando aplica)

**`admin/posts/index.blade.php`**
- Tabla con todos los artículos (publicados, programados y borradores).
- Estado: **Publicado** · fecha, **Programado** (en azul) · fecha y hora, **Borrador**.
- Acciones: Ver (solo publicados), Editar, Eliminar.
- Botones: "Nuevo artículo", "Exportar CSV".

**`admin/posts/form.blade.php`** — Formulario crear / editar:

| Campo | Tipo | Notas |
|---|---|---|
| Título | `text` | Genera el slug automáticamente en artículos nuevos |
| Categoría | `select` | 7 opciones predefinidas |
| Resumen | `textarea` | Máx. 300 caracteres |
| Contenido | Editor TipTap | HTML almacenado en `content` |
| Imagen destacada | `file` | jpeg, png, webp — máx. 2 MB. Preview + botón "Quitar imagen" si ya existe |
| Slug | `text` | Auto-generado, editable. Prefijo `/blog/` visible |
| Meta título | `text` | Máx. 70 chars con contador en tiempo real |
| Meta descripción | `textarea` | Máx. 160 chars con contador en tiempo real |
| Fecha de publicación | `datetime-local` | Vacío = borrador · pasada = publicar · futura = programar |

Acciones del formulario: **Guardar cambios** / **Crear artículo** · **Vista previa** (solo en posts existentes, abre en pestaña nueva) · **Cancelar**.

**`admin/mensajes/index.blade.php`**
- Lista todos los mensajes de contacto, 20 por página.
- Mensajes no leídos con borde dorado y badge "Nuevo".
- Muestra nombre, email (enlace `mailto:`), teléfono, fecha y hora, y mensaje completo.
- Botón "Marcar como leído" por mensaje.

---

## Editor WYSIWYG (TipTap)

### Versión

**TipTap v2** (v2.27.2). La v3 es incompatible con Vite 7 — ver [troubleshooting.md](./troubleshooting.md).

### Extensiones instaladas

| Paquete | Funcionalidad |
|---|---|
| `@tiptap/starter-kit` | Párrafos, headings, listas, blockquote, hr, code, bold, italic |
| `@tiptap/extension-underline` | Subrayado |
| `@tiptap/extension-image` | Imágenes externas (sin base64) |
| `@tiptap/extension-link` | Hipervínculos con autolink |

### Toolbar

| Botón | Acción |
|---|---|
| **B** | Negrita |
| *I* | Cursiva |
| U | Subrayado |
| H2 / H3 | Encabezados |
| Lista viñetas / numerada | `bulletList` / `orderedList` |
| Cita | `blockquote` |
| Línea separadora | `horizontalRule` |
| Enlace | `prompt()` para URL — `setLink` / `unsetLink` |
| Imagen | File picker → POST a `/admin/upload-image` → `setImage` |
| Deshacer / Rehacer | `undo` / `redo` |

Los botones se resaltan visualmente (`bg-midnight-900 text-white`) cuando el formato está activo en la selección actual.

### Flujo de imagen inline

1. Usuario hace clic en el botón de imagen.
2. Se abre un selector de archivos (jpeg, png, webp).
3. Se hace `fetch POST /admin/upload-image` con `FormData` (archivo + token CSRF del `<meta name="csrf-token">`).
4. El servidor almacena en `storage/app/public/posts/inline/` y devuelve `{ url: "..." }`.
5. El editor inserta `<img src="url" alt="nombre-archivo">` en la posición del cursor.

### Salida y renderizado

El editor genera HTML que se guarda en la columna `content`. En la vista pública se renderiza con:

```blade
{!! $post->content !!}
```

envuelto en un contenedor `prose prose-slate prose-lg` de Tailwind Typography.
