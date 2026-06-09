# Troubleshooting y decisiones técnicas

## Bugs resueltos

### `ParseError` — `@context` y `@type` en JSON-LD

**Síntoma:** Laravel lanza `ParseError: unexpected end of file expecting elseif/else/endif` al cargar cualquier vista que use el layout.

**Causa:** En Laravel 12, Blade interpreta `@context` y `@type` como directivas propias, generando bloques `if():` PHP sin cerrar dentro del JSON-LD del `<head>`.

**Solución:** Escapar con doble `@@`:
```blade
"@@context": "https://schema.org"
"@@type": "LegalService"
```
Blade renderiza `@@` como `@` literal. Aplica a **todos** los bloques JSON-LD del proyecto.

Después de cualquier cambio en vistas, limpiar el caché:
```bash
docker exec arsa-asociados-laravel.test-1 php artisan view:clear
```

---

### `MethodNotAllowedHttpException` — POST `/admin`

**Síntoma:** El formulario de login lanza un error 405 al enviar la contraseña.

**Causa:** El formulario hace `POST /admin`, pero dentro del grupo admin solo existía `Route::get('/')`. Laravel valida el método HTTP **antes** de ejecutar el middleware, por lo que el POST era rechazado antes de que `AdminPassword` pudiera procesarlo.

**Solución:** Agregar una ruta POST explícita dentro del grupo admin:
```php
Route::post('/', fn () => redirect()->route('admin.posts.index'));
```

---

### TipTap v3 incompatible con Vite 7

**Síntoma:** `Failed to resolve entry for package @tiptap/core. The package may have incorrect main/module/exports specified`.

**Causa:** TipTap v3 define una condición `types` en el campo `exports` de su `package.json` que Vite 7 resuelve incorrectamente.

**Solución:** Usar **TipTap v2** (`@tiptap/core@^2`). No requiere ninguna configuración adicional en `vite.config.js`.

```bash
docker exec arsa-asociados-laravel.test-1 npm install \
  @tiptap/core@^2 \
  @tiptap/starter-kit@^2 \
  @tiptap/extension-underline@^2 \
  @tiptap/extension-image@^2 \
  @tiptap/extension-link@^2
```

---

### `prose-midnight` no aplica estilos

**Síntoma:** El contenido del blog se muestra sin estilos tipográficos.

**Causa:** Dos problemas simultáneos:
1. El plugin `@tailwindcss/typography` no estaba instalado.
2. `prose-midnight` no existe como variante nativa del plugin (solo existen colores de Tailwind base como `slate`, `gray`, `zinc`, etc.).

**Solución:**
```bash
docker exec arsa-asociados-laravel.test-1 npm install @tailwindcss/typography --save-dev
```
Agregar en `app.css`:
```css
@plugin "@tailwindcss/typography";
```
Cambiar todas las ocurrencias de `prose-midnight` por `prose-slate`.

---

### Nombre de ruta duplicado en `export`

**Síntoma:** La ruta de exportación CSV generaba el nombre `admin.admin.posts.export`.

**Causa:** La ruta fue nombrada `admin.posts.export` dentro del grupo `name('admin.')`, resultando en el prefijo duplicado.

**Solución:** Nombrarla solo `posts.export` dentro del grupo:
```php
Route::get('posts/export', [PostAdminController::class, 'export'])->name('posts.export');
// → nombre final: admin.posts.export
```

---

### Links de navegación no funcionan desde el blog

**Síntoma:** Desde `/blog`, hacer clic en "Servicios", "Nosotros", "Testimonios" o "Contacto" no hace nada (no navega).

**Causa:** Los links usaban `#servicios` (ancla relativa). Desde `/blog` el navegador busca esa ancla en la página actual, que no existe.

**Solución:** Usar `/#servicios` (ancla absoluta). Los navegadores modernos resuelven esto correctamente: desde la home hacen solo scroll sin recargar; desde otras páginas navegan a la home y luego a la sección.

---

## Decisiones técnicas

### Por qué TipTap y no un textarea enriquecido

Se eligió TipTap por su integración nativa con Vite/ES Modules, su API limpia basada en ProseMirror y porque genera HTML estándar que Tailwind Typography puede estilizar directamente. La alternativa (CKEditor o Quill) requiere más configuración con Vite.

### Por qué autenticación por contraseña simple

El panel admin es de uso exclusivo de una persona. Implementar el sistema de autenticación completo de Laravel (users, passwords, emails, tokens) añadiría complejidad innecesaria. El middleware `AdminPassword` con sesión es suficiente para este caso de uso.

### Por qué almacenamiento local y no CDN

Para el volumen actual de contenido (30–50 artículos/mes estimado) el disco local es más que suficiente. La migración a Cloudflare R2 está documentada como tarea futura y es sencilla gracias a que Laravel abstrae el disco con `Storage::disk('public')`.

### Por qué `logo-icon.png` en lugar de `logo.png` en el footer

El logo completo (`logo.png`) tiene texto que no es legible en tamaños pequeños sobre fondo oscuro. El escudo solo (`logo-icon.png`) es más legible y versátil en fondos `midnight-950`.

### Por qué guardar mensajes en BD antes de enviar el email

Si el servidor de correo falla (caída del proveedor, configuración incorrecta, spam), el mensaje del cliente se perdería. Guardar primero en BD garantiza que el mensaje siempre esté disponible en el panel admin, independientemente de lo que ocurra con el email.

### Por qué `config()` y no `env()` en controladores

Laravel cachea la configuración en producción con `php artisan config:cache`. Una vez cacheada, las llamadas directas a `env()` devuelven `null` porque el archivo `.env` ya no se carga. Todo acceso a variables de entorno debe hacerse a través de `config()`, que lee el archivo cacheado correctamente.

```php
// ❌ Falla en producción con config cacheado
env('MAIL_CONTACT_ADDRESS', 'default@ejemplo.cl')

// ✅ Correcto
config('app.mail_contact_address', 'default@ejemplo.cl')
```

Requiere que la clave exista en `config/app.php`:
```php
'mail_contact_address' => env('MAIL_CONTACT_ADDRESS', 'catalynaarmas@gmail.com'),
```

---

### Por qué `@@context` y no `@context` en JSON-LD

Laravel 12 procesa directivas Blade que empiecen con `@` antes de renderizar el HTML. `@context` y `@type` son interpretadas como directivas inexistentes, generando un `ParseError`. Blade convierte `@@` en `@` literal, por lo que `@@context` se renderiza correctamente como `@context` en el HTML final.
