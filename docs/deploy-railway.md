# Deploy en Railway — Arsa & Asociados

Guía paso a paso para desplegar el proyecto en Railway (entorno de pruebas).

---

## Pre-requisitos

- Cuenta gratuita en [railway.app](https://railway.app)
- Repositorio del proyecto en **GitHub** (Railway lo necesita para el deploy automático)
- El archivo `railway.toml` ya está incluido en la raíz del proyecto

---

## Paso 1 — Subir el código a GitHub

Si el proyecto aún no está en GitHub, créalo desde la terminal:

```bash
git init
git add .
git commit -m "Initial commit"
gh repo create arsa-asociados --private --source=. --push
```

> Si no tienes la CLI de GitHub (`gh`), crea el repositorio manualmente en github.com y luego conecta con `git remote add origin <url>`.

---

## Paso 2 — Crear proyecto en Railway

1. Entra a [railway.app](https://railway.app) e inicia sesión
2. Clic en **"New Project"**
3. Selecciona **"Deploy from GitHub repo"**
4. Autoriza Railway para acceder a tu GitHub y selecciona el repositorio `arsa-asociados`
5. Railway detectará automáticamente el `railway.toml` y usará **Nixpacks** como builder

---

## Paso 3 — Agregar MySQL

1. Dentro del proyecto en Railway, clic en **"+ New"** → **"Database"** → **"Add MySQL"**
2. Railway crea el servicio y genera las variables de conexión automáticamente
3. Anota el nombre del servicio (por defecto: `MySQL`)

---

## Paso 4 — Agregar Redis

1. Clic en **"+ New"** → **"Database"** → **"Add Redis"**
2. Railway crea el servicio Redis automáticamente
3. Anota el nombre del servicio (por defecto: `Redis`)

---

## Paso 5 — Configurar variables de entorno

Ve al servicio de la aplicación (el que viene de GitHub) → pestaña **"Variables"** → clic en **"Raw Editor"** y pega lo siguiente, completando los valores indicados:

```env
APP_NAME=Arsa & Asociados
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

REDIS_HOST=${{Redis.REDIS_HOST}}
REDIS_PORT=${{Redis.REDIS_PORT}}
REDIS_PASSWORD=${{Redis.REDIS_PASSWORD}}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

LOG_CHANNEL=stderr
LOG_LEVEL=error

ADMIN_PASSWORD=
```

### Valores que debes completar manualmente

| Variable | Cómo obtenerla |
|---|---|
| `APP_KEY` | Ejecutar en consola Railway: `php artisan key:generate --show` |
| `ADMIN_PASSWORD` | Inventar una contraseña segura (mín. 16 caracteres) |

> **Nota sobre `${{MySQL.*}}` y `${{Redis.*}}`**: Railway reemplaza estas referencias automáticamente con los valores reales del servicio. Solo funcionan si los servicios se llaman exactamente `MySQL` y `Redis`. Si les pusiste otro nombre, ajusta el prefijo.

---

## Paso 6 — Generar APP_KEY

Railway permite abrir una terminal en el contenedor. Ve a tu servicio → pestaña **"Deploy"** → clic en **"Railway Shell"** (o usa la CLI):

```bash
php artisan key:generate --show
```

Copia el resultado (empieza con `base64:...`) y pégalo en la variable `APP_KEY`.

---

## Paso 7 — Hacer el deploy

1. Railway hace el deploy automáticamente al conectar el repo
2. Si necesitas forzarlo: ve a la pestaña **"Deployments"** → clic en **"Deploy Now"**
3. Monitorea los logs en tiempo real desde la pestaña **"Logs"**

El comando de inicio configurado en `railway.toml` hará automáticamente:
- `php artisan migrate --force` — ejecuta las migraciones
- `php artisan config:cache` — optimiza la configuración
- `php artisan route:cache` — optimiza las rutas
- `php artisan storage:link` — crea el symlink de storage
- Inicia el servidor PHP en el puerto asignado por Railway

---

## Paso 8 — Acceder al sitio

1. Ve a tu servicio → pestaña **"Settings"** → sección **"Networking"**
2. Clic en **"Generate Domain"** para obtener una URL pública como `arsa-asociados.up.railway.app`
3. Actualiza la variable `APP_URL` con esa URL exacta
4. Accede al panel admin en: `https://arsa-asociados.up.railway.app/admin`

---

## Verificación rápida

- [ ] La página principal carga correctamente
- [ ] El blog (`/blog`) muestra los posts
- [ ] El panel admin (`/admin`) pide contraseña y permite ingresar
- [ ] El formulario de contacto (`/#contacto`) funciona sin errores
- [ ] El sitemap está disponible en `/sitemap.xml`

---

## Notas importantes — Plan gratuito

| Límite | Valor |
|---|---|
| Crédito mensual | $5 USD |
| RAM | 512 MB |
| CPU | Compartida |
| Almacenamiento | 1 GB |
| Inactividad | El servicio **no duerme** (a diferencia de Render) |

> Para un sitio de pruebas con bajo tráfico, los $5 USD mensuales son suficientes. Si el crédito se agota, el proyecto se pausa hasta el siguiente ciclo.

---

## Comandos útiles con Railway CLI (opcional)

```bash
# Instalar CLI
npm install -g @railway/cli

# Login
railway login

# Conectar proyecto local
railway link

# Abrir shell en el contenedor
railway shell

# Ver logs en tiempo real
railway logs

# Ejecutar comandos artisan
railway run php artisan migrate:status
```
