# Arsa & Asociados — Documentación

Sitio web institucional para el estudio jurídico **Arsa & Asociados**, con panel de administración para gestión de artículos de blog y mensajes de contacto.

---

## Estado actual del proyecto

**Última sesión:** 17 de marzo de 2026 (sesión 2)

### Lo que está 100% terminado

- Homepage completa (6 secciones: Hero, Servicios, Nosotros, Cómo trabajamos, Testimonios, Contacto)
- Blog público con listado paginado, búsqueda por texto y filtros por categoría
- Vista de artículo individual con tiempo de lectura estimado
- Panel de administración con CRUD completo de artículos
- Editor WYSIWYG (TipTap v2) con toolbar completa y subida de imágenes inline
- Imágenes destacadas por artículo (subida, preview, reemplazo, eliminación con botón)
- Publicación programada (campo datetime — borradores, publicación inmediata o futura)
- Vista previa de borradores desde el panel admin
- Exportación CSV compatible con Excel (muestra estado Publicado/Programado/Borrador)
- SEO completo: meta tags, Open Graph (`og:type` dinámico), Twitter Card, JSON-LD global (`LegalService`) y por artículo (`BlogPosting`), sitemap
- Campos SEO editables por artículo (`meta_title`, `meta_description`)
- Slug editable por artículo con auto-generación, validación única en BD
- Logos integrados (navbar, footer, admin, favicon)
- Páginas legales (política de privacidad, términos de uso)
- Formulario de contacto con envío de email + guardado en base de datos
- Panel admin de mensajes de contacto con estado leído/no leído
- Rate limiting en el formulario de contacto (3 envíos/min por IP)
- Rate limiting en el login admin (5 intentos fallidos, bloqueo 60 seg por IP)
- Slugs con unicidad garantizada — sin crash si dos posts tienen el mismo título
- Links de navegación funcionales desde cualquier página (anclas con prefijo `/`)

### Lo que está pendiente

| Tarea | Prioridad |
|---|---|
| Foto de Nicool Armas en sección `#nosotros` | Alta |
| Testimonios reales en sección `#testimonios` | Alta |
| Migración de imágenes a Cloudflare R2 | Media |
| Extensión de tablas para TipTap | Baja |

### Cómo retomar

```bash
cd ~/proyectosClaude/arsa-asociados
./vendor/bin/sail up -d
./vendor/bin/sail npm run dev
```

Luego abrir `http://localhost` para el sitio y `http://localhost/admin` para el panel.

---

## Documentos

| Archivo | Contenido |
|---|---|
| [entorno.md](./entorno.md) | Stack, Docker, variables de entorno, comandos frecuentes |
| [arquitectura.md](./arquitectura.md) | Estructura de carpetas, rutas, controladores, modelos, middleware |
| [base-de-datos.md](./base-de-datos.md) | Esquema de tablas `posts` y `contact_messages`, migraciones |
| [frontend.md](./frontend.md) | Sistema de diseño, vistas Blade, editor TipTap |
| [seo.md](./seo.md) | Meta tags, Open Graph, JSON-LD, campos SEO por artículo |
| [seguridad.md](./seguridad.md) | Modelo de autenticación, protecciones activas, checklist de despliegue |
| [troubleshooting.md](./troubleshooting.md) | Bugs resueltos, decisiones técnicas |

---

## Accesos rápidos

| URL | Descripción |
|---|---|
| `http://localhost` | Sitio público |
| `http://localhost/blog` | Listado de artículos |
| `http://localhost/admin` | Panel de administración |
| `http://localhost/admin/mensajes` | Mensajes de contacto recibidos |
| `http://localhost/sitemap.xml` | Sitemap para buscadores |
