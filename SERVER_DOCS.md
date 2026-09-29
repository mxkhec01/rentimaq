# Documentación del Servidor y Despliegue - Rentimaq

Documento de referencia técnica sobre la infraestructura, conexión al panel Plesk, acceso SSH y diagnóstico de rendimiento para el proyecto Rentimaq.

---

## 1. Datos del Servidor

| Parámetro | Valor |
|---|---|
| **Proveedor** | IONOS SE (Servidor Virtual / VPS) |
| **Dirección IP** | `74.208.51.55` |
| **Hostname / Reverse DNS** | `huguete.com` |
| **Sistema Operativo** | Ubuntu Linux |
| **Panel de Administración** | Plesk Obsidian |
| **Puerto Plesk** | `8443` |
| **Puerto SSH** | `22` |

---

## 2. Acceso y Conexión

### 2.1 Panel Web de Plesk
* **URL:** [https://74.208.51.55:8443](https://74.208.51.55:8443) o [https://huguete.com:8443](https://huguete.com:8443)
* **Usuario:** `root` (o `admin`)
* **Contraseña:** Contraseña configurada en IONOS / Plesk.
* *Nota:* Si el certificado SSL del panel es autofirmado, omitir la advertencia del navegador pulsando en *Configuración avanzada > Continuar*.

### 2.2 Conexión por SSH (Terminal)
Desde terminal PowerShell o Linux/macOS:
```bash
ssh root@74.208.51.55
```
o bien:
```bash
ssh root@huguete.com
```

### 2.3 Ubicación del Proyecto en el Servidor
En Plesk, los sitios web se alojan típicamente en:
```bash
cd /var/www/vhosts/<nombre-del-dominio>/httpdocs
```
*(Donde `<nombre-del-dominio>` corresponde al dominio configurado para Rentimaq, por ejemplo `rentimaq.com`)*.

> [!IMPORTANT]
> La raíz web pública (**Document Root**) en la configuración del dominio en Plesk debe apuntar obligatoriamente a `/httpdocs/public`, nunca a la raíz del proyecto.

---

## 3. Integración con Plesk (Laravel Toolkit)

El proyecto incluye el paquete oficial `plesk/ext-laravel-integration` en [composer.json](composer.json). Esto permite que la extensión **Laravel Toolkit** de Plesk gestione la aplicación:

1. **Gestión de `.env`**: Las variables se pueden editar directamente desde el panel de Plesk en *Laravel Toolkit > Environment*.
2. **Despliegue Git**: Las actualizaciones de la rama `main` pueden desplegarse automáticamente con el botón *Pull / Desplegar*.
3. **Versión de PHP**: Configurada en PHP 8.2 o superior en modo PHP-FPM.

---

## 4. Diagnóstico y Manejo de Memoria (RAM y Swap)

En servidores VPS de recursos moderados (1 GB a 2 GB de RAM), Laravel junto con Plesk, MySQL y colas pueden experimentar saturación de memoria. A continuación se detallan las medidas de optimización aplicadas y cómo resolver incidentes:

### 4.1 Evitar OOM en `composer install` / Despliegues
Cuando Composer se queda sin memoria, el kernel Linux lo termina abruptamente (`Killed` o `Out of memory`).
* **Opción A (Memoria ilimitada para Composer):**
  ```bash
  COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader
  ```
* **Opción B (Habilitar o ampliar SWAP de 2 GB si no existe):**
  ```bash
  sudo fallocate -l 2G /swapfile
  sudo chmod 600 /swapfile
  sudo mkswap /swapfile
  sudo swapon /swapfile
  # Para hacerlo persistente tras reinicios, agregar a /etc/fstab:
  echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab
  ```

### 4.2 Límite de Memoria PHP (`memory_limit`)
Filament v5 y Livewire consumen más memoria que una aplicación Laravel tradicional.
* En **Plesk > Dominio > PHP Settings**:
  * Establecer `memory_limit` en al menos **`256M`** (recomendado **`512M`**).
  * `max_execution_time` = **`60`** segundos.
  * `upload_max_filesize` = **`20M`** (para subida de imágenes de productos).

### 4.3 Workers de Colas (`queue:work`)
Los correos (`ContactoMail`, `FacturacionMail`, `QuoteRequested`) implementan `ShouldQueue`.
* Para evitar fugas de memoria (*memory leaks*) en el worker de colas, se debe ejecutar con límites de reciclaje de proceso:
  ```bash
  php artisan queue:work --max-jobs=1000 --max-time=3600 --memory=128 --tries=3
  ```
* Si se gestiona desde el **Laravel Toolkit** de Plesk o con *Supervisor*, asegurarse de que el comando incluya el flag `--memory=128` y reinicie el worker tras cada despliegue con:
  ```bash
  php artisan queue:restart
  ```

### 4.4 Comandos Rápidos de Diagnóstico por SSH
```bash
# 1. Comprobar uso de memoria física y swap
free -h

# 2. Ver los procesos que más memoria consumen actualmente
ps aux --sort=-%mem | head -n 11

# 3. Verificar si el OOM Killer ha matado procesos recientemente
dmesg -T | grep -i -E "oom|killed process"

# 4. Estado de servicios principales
systemctl status mariadb
systemctl status nginx
```

---

## 5. Rutina de Despliegue Manual por SSH

Si se requiere actualizar el servidor manualmente sin pasar por la interfaz de Plesk:

```bash
cd /var/www/vhosts/<nombre-del-dominio>/httpdocs

# 1. Bajar últimos cambios
git pull origin main

# 2. Instalar dependencias optimizadas
COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader

# 3. Ejecutar migraciones si las hay
php artisan migrate --force

# 4. Optimizar cachés de Laravel
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Reiniciar colas
php artisan queue:restart
```
