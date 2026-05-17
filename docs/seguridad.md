# Seguridad

Resumen del modelo de seguridad del proyecto, vulnerabilidades analizadas y checklist de despliegue.

---

## Modelo de autenticación del panel admin

El panel `/admin` usa un middleware propio (`AdminPassword`) sin el sistema de usuarios de Laravel. Es suficiente para un solo administrador.

**Flujo:**
1. Petición llega → middleware verifica `session('admin_authenticated')`
2. Si no hay sesión activa y es POST → valida rate limit → compara contraseña con `config('app.admin_password')`
3. Éxito: limpia el contador, guarda la sesión, redirige al panel
4. Fallo: incrementa el contador, muestra error

**Protección contra fuerza bruta:**
- Máximo **5 intentos fallidos** por IP
- Bloqueo de **60 segundos** al exceder el límite
- Implementado con `Illuminate\Support\Facades\RateLimiter` (misma infraestructura que el throttle de rutas)
- Al autenticarse correctamente, el contador se reinicia con `RateLimiter::clear()`

```php
// app/Http/Middleware/AdminPassword.php
$key = 'admin-login:' . $request->ip();

if (RateLimiter::tooManyAttempts($key, 5)) {
    $seconds = RateLimiter::availableIn($key);
    // HTTP 429 + mensaje de espera
}
// ...
RateLimiter::hit($key, 60); // 60 seg de ventana
```

---

## Protecciones activas

| Área | Mecanismo | Detalle |
|---|---|---|
| CSRF | `@csrf` en todos los formularios | Laravel middleware `VerifyCsrfToken` global |
| Inyección SQL | Eloquent ORM | Nunca se construyen queries con concatenación de strings |
| XSS | `{{ }}` de Blade | Escapa HTML por defecto; `{!! !!}` solo en contenido de TipTap ya saneado por el editor |
| Subida de archivos | Validación estricta | `mimes:jpeg,png,webp`, `max:2048` KB, almacenado en `storage/` fuera de `public/` |
| Formulario contacto | Rate limiting | `throttle:3,1` — máximo 3 envíos por minuto por IP |
| Login admin | Rate limiting | `RateLimiter` — máximo 5 intentos, bloqueo 60 segundos por IP |
| Slugs | `Str::slug()` | Sanitización automática antes de guardar |
| Config en producción | `config()` (no `env()`) | Compatible con `php artisan config:cache` |

---

## Variables de entorno — producción

Antes de desplegar, el `.env` debe tener exactamente estos valores:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://arsayasociados.cl

ADMIN_PASSWORD=<contraseña larga y aleatoria, mínimo 20 caracteres>

SESSION_ENCRYPT=true
SESSION_DOMAIN=arsayasociados.cl
SESSION_SECURE_COOKIE=true
```

> **Por qué `APP_DEBUG=false`:** Con `true`, cualquier error no controlado expone el stack trace completo en el navegador, incluyendo variables de entorno, rutas de archivos del servidor y fragmentos del código fuente.

> **Por qué `SESSION_ENCRYPT=true`:** Cifra el contenido de la cookie de sesión. Sin esto, aunque la cookie sea opaca, un atacante con acceso al almacenamiento de sesiones podría leer su contenido.

> **Por qué `SESSION_SECURE_COOKIE=true`:** Instruye al navegador a enviar la cookie solo por HTTPS, evitando que sea interceptada en tránsito.

### Generar una contraseña admin segura

```bash
# En el servidor o localmente — genera 32 caracteres aleatorios
openssl rand -base64 32
```

---

## Comandos post-despliegue

Después de actualizar el `.env` en producción:

```bash
docker exec arsa-asociados-laravel.test-1 php artisan config:cache
docker exec arsa-asociados-laravel.test-1 php artisan route:cache
docker exec arsa-asociados-laravel.test-1 php artisan view:clear
```

> `config:cache` es importante porque consolida todas las variables de entorno en un archivo PHP compilado. Tras ejecutarlo, `env()` directamente en código ya no funciona — por eso todos los valores se leen con `config()`.

---

## Limitaciones conocidas y aceptadas

### Autenticación por contraseña simple
El panel admin no usa el sistema de autenticación estándar de Laravel (usuarios, tokens, 2FA). Es una decisión deliberada: el sitio tiene un único administrador y agregar el stack completo de Auth añadiría complejidad desproporcionada. Ver razonamiento completo en [troubleshooting.md](./troubleshooting.md#por-qué-autenticación-por-contraseña-simple).

**Mitigación:** contraseña larga + rate limiting por IP.

### Sin HTTPS forzado en código
No hay un redirect HTTP → HTTPS implementado en Laravel. Esto debe configurarse a nivel de servidor (Nginx/Caddy) o de proxy (Cloudflare). Es la capa correcta para hacerlo.

### Contenido del editor no se sanea en el servidor
El HTML generado por TipTap se guarda y renderiza con `{!! $post->content !!}`. TipTap ya restringe el HTML a sus extensiones activas (sin `<script>`, sin atributos `on*`), pero no hay un paso de saneado server-side adicional (ej. HTMLPurifier). Esto es aceptable porque el único que puede crear contenido es el administrador autenticado.

---

## Historial de cambios de seguridad

| Fecha | Cambio |
|---|---|
| 17 mar 2026 | Rate limiting en login admin (5 intentos / 60 seg) — `AdminPassword.php` |
| 17 mar 2026 | Reemplazado `env()` por `config()` en `ContactController` — compatible con config cache |
| 17 mar 2026 | Agregada clave `mail_contact_address` en `config/app.php` |
