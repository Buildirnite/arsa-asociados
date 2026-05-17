# SEO

## Meta tags globales

El componente `x-layout` genera automáticamente todos los meta tags en el `<head>`. Acepta props que permiten personalizar el SEO por página.

```html
<title>{{ $metaTitle }}</title>
<meta name="description"        content="{{ $metaDescription }}">
<link rel="canonical"           href="{{ $metaUrl }}">

<!-- Open Graph -->
<meta property="og:type"        content="{{ $ogType }}">   <!-- 'website' por defecto, 'article' en el blog -->
<meta property="og:url"         content="{{ $metaUrl }}">
<meta property="og:title"       content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:image"       content="{{ $ogImage }}">
<meta property="og:locale"      content="es_CL">
<meta property="og:site_name"   content="Arsa & Asociados">

<!-- Twitter Card -->
<meta name="twitter:card"        content="summary">
<meta name="twitter:title"       content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image"       content="{{ $ogImage }}">
```

---

## Props del layout

| Prop | Default | Uso |
|---|---|---|
| `:title` | Título genérico del estudio | `<title>` y OG title |
| `:description` | Descripción genérica | `<meta name="description">` |
| `:canonical` | URL actual | `<link rel="canonical">` |
| `:ogImage` | `logo-icon.png` | `og:image` y Twitter card |
| `ogType` | `website` | `og:type` — usar `article` en artículos del blog |

### Slot `headExtra`

Para inyectar contenido adicional en el `<head>` (JSON-LD extra, meta tags específicos):

```blade
<x-layout ogType="article" ...>
    <x-slot:headExtra>
        <script type="application/ld+json">...</script>
    </x-slot:headExtra>

    contenido...
</x-layout>
```

---

## SEO por artículo

Cada artículo puede tener su propio `meta_title` y `meta_description` editables desde el panel admin. Si están vacíos, el sistema usa valores de fallback automáticamente.

| Campo DB | Límite | Fallback |
|---|---|---|
| `meta_title` | 70 caracteres | `$post->title . ' — Arsa & Asociados'` |
| `meta_description` | 160 caracteres | `$post->excerpt` |
| `og:image` | — | `logo-icon.png` si el post no tiene imagen destacada |
| `og:type` | — | `article` (siempre en artículos del blog) |

---

## Slug

- Se genera automáticamente desde el título al crear un artículo (vía JavaScript en el formulario).
- Es editable antes de guardar en artículos nuevos y en cualquier momento al editar.
- Al guardar, siempre se normaliza con `Str::slug()` (minúsculas, sin tildes, sin caracteres especiales).
- Único en base de datos con validación `Rule::unique` (devuelve error de validación, no error 500).

---

## Sitemap

Ruta: `GET /sitemap.xml`

Genera un sitemap XML con todos los artículos **publicados**, ordenados por `updated_at` DESC. Útil para que Google descubra el contenido nuevo automáticamente.

Para registrarlo en Google Search Console usar la URL:
```
https://arsayasociados.cl/sitemap.xml
```

---

## JSON-LD (Datos estructurados)

### Global — `LegalService` (en el layout)

Presente en **todas** las páginas del sitio:

```json
{
  "@context": "https://schema.org",
  "@type": "LegalService",
  "name": "Arsa & Asociados",
  "telephone": "+56930676693",
  "email": "contacto@arsayasociados.cl",
  "address": { "@type": "PostalAddress", "addressLocality": "Santiago", "addressCountry": "CL" },
  "openingHours": "Mo-Fr 09:00-18:00"
}
```

### Por artículo — `BlogPosting` (en `blog/show.blade.php`)

Presente en **cada artículo** del blog:

```json
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "Título del artículo",
  "description": "Meta description o excerpt",
  "url": "https://arsayasociados.cl/blog/slug",
  "datePublished": "2026-03-17T12:00:00+00:00",
  "dateModified": "2026-03-17T14:00:00+00:00",
  "author": {
    "@type": "Person",
    "name": "Nicool Armas",
    "jobTitle": "Abogada",
    "worksFor": { "@type": "Organization", "name": "Arsa & Asociados" }
  },
  "publisher": { "@type": "Organization", "name": "Arsa & Asociados" },
  "image": "https://..." // Solo si el artículo tiene imagen destacada
}
```

> **Nota Blade:** las claves `@context` y `@type` se escriben como `@@context` y `@@type` en Blade para evitar que sean interpretadas como directivas. Ver [troubleshooting.md](./troubleshooting.md).

---

## Almacenamiento de imágenes

Las imágenes se guardan localmente en disco `public` de Laravel.

```
storage/app/public/
├── posts/          → imágenes destacadas
└── posts/inline/   → imágenes insertadas en el contenido (TipTap)
```

Accesibles públicamente via el symlink `public/storage/` → `storage/app/public/`.

```bash
# Crear el symlink si no existe
docker exec arsa-asociados-laravel.test-1 php artisan storage:link
```

**Recomendación futura:** migrar a **Cloudflare R2** cuando el volumen de imágenes crezca. Es compatible con la API de S3 de Laravel y tiene un plan gratuito generoso.
