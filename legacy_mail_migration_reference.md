# Referencia de Migración: Sistema de Correo Legacy → Laravel + Filament

> Documento consolidado con todo el sistema de correo del sitio legacy de Rentimaq para su migración al proyecto Laravel + Filament.

---

## 1. Resumen: Dos Sistemas de Envío Coexistentes

El legacy tiene **dos mecanismos de envío distintos** según el origen de la página:

| Sistema | Ubicación | Método | Páginas |
|---|---|---|---|
| **Landing Pages** (estáticos) | `renta-maquinaria-ligera-construccion/`, `venta-maquinaria-ligera-construccion/` | `mail()` nativo de PHP | Formulario de cotización de renta/venta |
| **Sitio CodeIgniter** | [application/controllers/Rentimaq.php](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/controllers/Rentimaq.php) | **SocketLabs API** vía cURL | Facturación, Contacto, Cotización |

---

## 2. Sistema 1: Landing Pages (PHP `mail()` nativo)

### Origen → Destino

| Archivo fuente | Acción del form | Redirect después |
|---|---|---|
| `renta-…/index.html` | [contacto.php](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/views/contacto.php) (POST) | [index.html](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/user_guide/genindex.html) |
| `venta-…/index.html` | [contacto.php](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/views/contacto.php) (POST) | [index.html](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/user_guide/genindex.html) |

> [!NOTE]
> El formulario de **renta** está **comentado** en el HTML y fue reemplazado por un formulario de **HubSpot** (Portal `8678337`, Form `d2f1c6a4-765c-4a9f-85ac-903188272488`). El de **venta** solo tiene botón de WhatsApp.

### Configuración de envío

| Parámetro | Valor |
|---|---|
| Método | `mail()` nativo (sin SMTP) |
| Asunto | `Correo de RENTIMAQ` |
| From (renta) | `LP RENTIMAQ RENTA <www.rentimaq.com/renta>` ⚠️ inválido |
| From (venta) | `LP RENTIMAQ VENTA <www.rentimaq.com/venta>` ⚠️ inválido |

### Destinatarios

| Email | Rol probable |
|---|---|
| `amoran@rentimaq.com` | Contacto principal |
| `pamela@conceptexperts.com` | Agencia externa |
| `smartalexresults@gmail.com` | Marketing externo |

### Campos — Formulario de Renta (con detalle por equipo)

Cada equipo tiene 3 sub-campos: **unidad**, **tiempo** y **periodo** (dias/semanas/meses).

| Equipo | Unidad | Tiempo | Periodo |
|---|---|---|---|
| Compactadoras (bailarinas) | `compactadoras` | `compactadorast` | `opcompactadoras` |
| Revolvedoras de un saco | `revolvedora` | `revolvedorat` | `oprevolvedora` |
| Allanadoras 36" SIN plato | `allanadorassin` | `allanadorassint` | `opallanadorassin` |
| Allanadoras 36" CON plato | `allanadorascon` | `allanadorascont` | `opallanadorascon` |
| Vibradores gasolina 4mts | `vgasolina` | `vgasolinat` | `opvgasolina` |
| Vibradores eléctrico 4mts | `velectrico` | `velectricot` | `opvelectrico` |
| Rompedoras de piso 30 kg | `rompedora` | `rompedorat` | `oprompedora` |
| Generador 5,000 W | `generador` | `generadort` | `opgenerador` |
| Módulo andamio | `andamio` | `andamiot` | `opandamio` |
| Tablón para andamio | `tablon` | `tablont` | `optablon` |

También incluye un campo general: `equipo` (texto libre).

### Campos — Formulario de Venta (solo nombre de equipo, sin detalle)

Mismos 10 equipos pero solo un campo por cada uno (sin unidad/tiempo/periodo).

### Datos de contacto (compartidos renta y venta)

| Campo | Name | Tipo | Requerido |
|---|---|---|---|
| Nombre | `nombre` | text | ✅ |
| Empresa | `empresa` | text | ✅ |
| Teléfono | `telefono` | text | ✅ |
| Correo | `email` | email | ✅ |
| Dirección de obra | `direccion` | text | ✅ |
| Ciudad | `ciudad` | text | ✅ |

---

## 3. Sistema 2: Sitio CodeIgniter (SocketLabs API)

### Configuración de SocketLabs

| Parámetro | Valor |
|---|---|
| **API Endpoint** | `https://inject.socketlabs.com/api/v1/email` |
| **Server ID** | `26067` |
| **API Key** | `t6P8Zgx9M5Ack3RGe4f7` |
| **From** | `contacto@conceptexperts.com` |
| **Formato** | HTML (tabla generada dinámicamente) |

### Destinatarios (se envían 2 cURL en secuencia)

| # | Email |
|---|---|
| 1 | `contacto@rentimaq.com` |
| 2 | `amoran@rentimaq.com` |

### Post-envío

Todas las funciones redirigen a `https://www.rentimaq.com/rentimaq/typ` (Thank You Page).

---

### 3.1 Formulario de FACTURACIÓN

| Aspecto | Detalle |
|---|---|
| **URL** | `rentimaq/facturacion` |
| **Vista** | [application/views/facturacion.php](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/views/facturacion.php) |
| **Form action** | `POST → rentimaq/envio` |
| **Función controller** | `Rentimaq::envio()` |
| **Campo hidden** | `tipo = "Facturación"` |

#### Campos

| Campo | Name HTML | Requerido |
|---|---|---|
| Razón social | `Razon social` | ✅ |
| RFC | `RFC` | ✅ |
| Calle | `Calle` | ✅ |
| No. Exterior | `No exterior` | ✅ |
| No. Interior | `No interior` | ✅ |
| Colonia | `Colonia` | ✅ |
| Cuenta de pago | `Cuenta` | ✅ |
| Ciudad | `Ciudad` | ✅ |
| Municipio | `Municipio` | ✅ |
| Estado | `Estado` | ✅ |
| País | `Pais` | ✅ |
| Código postal | `CP` | ✅ |
| E-mail | `Email` | ✅ |

---

### 3.2 Formulario de CONTACTO

| Aspecto | Detalle |
|---|---|
| **URL** | `rentimaq/contacto` |
| **Vista** | [application/views/contacto.php](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/views/contacto.php) |
| **Form action** | `POST → rentimaq/envio` |
| **Función controller** | `Rentimaq::envio()` (misma que facturación, genérica) |
| **Campo hidden** | `tipo = "Contacto"` |

#### Campos

| Campo | Name HTML | Requerido |
|---|---|---|
| Nombre | `nombre` | ✅ |
| Correo | `correo` | ✅ |
| Empresa | `empresa` | ✅ |
| Asunto | `asunto` | ✅ |
| Mensaje | `mensaje` | No |

> Info adicional visible en la página: **Tel: 442 2121210**, **contacto@rentimaq.com**

---

### 3.3 Formulario de COTIZACIÓN (Renta/Venta)

| Aspecto | Detalle |
|---|---|
| **URL** | `rentimaq/cotizacion` |
| **Vista** | [application/views/cotizacion.php](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/views/cotizacion.php) |
| **Form action** | `POST → rentimaq/envio2` |
| **Función controller** | `Rentimaq::envio2()` |
| **Campo tipo** | Radio: `"renta"` o `"venta"` |

#### Campos de contacto

| Campo | Name HTML | Requerido |
|---|---|---|
| Nombre | `nombre` | ✅ |
| Teléfono | `telefono` | ✅ |
| Ciudad | `ciudad` | ✅ |
| Empresa | `empresa` | ✅ |
| Correo | `correo` | ✅ |

#### Selección de equipos (dinámico vía JS)

10 productos con campos indexados `t0`–`t9` (cantidad), `c0`–`c9` (tiempo), `op0`–`op9` (periodo). Si `tipo == "renta"` incluye tiempo y periodo; si `tipo == "venta"` solo cantidad.

---

## 4. Diferencias clave entre [envio()](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/controllers/Rentimaq.php#99-155) y [envio2()](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/controllers/Rentimaq.php#156-251)

| Aspecto | [envio()](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/controllers/Rentimaq.php#99-155) | [envio2()](file:///c:/Users/Usuario/OneDrive/rentimaq_legacy/_legacy_codeigniter/application/controllers/Rentimaq.php#156-251) |
|---|---|---|
| **Usado por** | Facturación, Contacto | Cotización |
| **Lógica** | Genérica: itera `$_POST` completo | Específica: arma tabla de productos seleccionados |
| **Formato del body** | Tabla con todos los campos del POST | Tabla con datos de contacto + lista de productos con cantidad |

---

## 5. Configuración Requerida en Laravel

### 5.1 Archivo `.env`

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.ejemplo.com
MAIL_PORT=587
MAIL_USERNAME=noreply@rentimaq.com
MAIL_PASSWORD=xxxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@rentimaq.com
MAIL_FROM_NAME="Rentimaq"
```

> [!CAUTION]
> El cliente **debe proveer** credenciales SMTP. Si se desea mantener SocketLabs, las credenciales existentes son Server ID `26067` y API Key `t6P8Zgx9M5Ack3RGe4f7` — pero verificar vigencia.

---

### 5.2 Tabla de Contactos de Correo (administrable desde Filament)

En lugar de hardcodear destinatarios, crear una tabla `email_contacts` administrable desde el panel de Filament:

```sql
CREATE TABLE email_contacts (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(255) NOT NULL,
    email           VARCHAR(255) NOT NULL UNIQUE,
    recibe_facturacion   BOOLEAN DEFAULT FALSE,
    recibe_cotizacion    BOOLEAN DEFAULT FALSE,
    recibe_contacto      BOOLEAN DEFAULT FALSE,
    activo               BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP NULL,
    updated_at      TIMESTAMP NULL
);
```

#### Datos iniciales (migración con seed)

```php
// database/seeders/EmailContactSeeder.php
EmailContact::insert([
    ['nombre' => 'Contacto Rentimaq', 'email' => 'contacto@rentimaq.com',
     'recibe_facturacion' => true,  'recibe_cotizacion' => true,  'recibe_contacto' => true],
    ['nombre' => 'A. Morán',         'email' => 'amoran@rentimaq.com',
     'recibe_facturacion' => true,  'recibe_cotizacion' => true,  'recibe_contacto' => true],
]);
```

#### Resource de Filament

```php
// app/Filament/Resources/EmailContactResource.php
// Campos en el formulario:
Forms\Components\TextInput::make('nombre')->required(),
Forms\Components\TextInput::make('email')->email()->required()->unique(),
Forms\Components\Toggle::make('recibe_facturacion')->label('Facturación'),
Forms\Components\Toggle::make('recibe_cotizacion')->label('Cotizaciones'),
Forms\Components\Toggle::make('recibe_contacto')->label('Contacto General'),
Forms\Components\Toggle::make('activo')->label('Activo')->default(true),
```

#### Uso en los Mailables

```php
// Al enviar un correo de facturación:
$destinatarios = EmailContact::where('activo', true)
    ->where('recibe_facturacion', true)
    ->pluck('email')
    ->toArray();

Mail::to($destinatarios)->send(new FacturacionMail($data));
```

---

### 5.3 Mailables a crear

| Mailable | Template Blade | Tipo de formulario |
|---|---|---|
| `FacturacionMail` | `emails/facturacion.blade.php` | Datos fiscales completos |
| `CotizacionMail` | `emails/cotizacion.blade.php` | Equipos + tipo renta/venta + contacto |
| `ContactoMail` | `emails/contacto.blade.php` | Nombre, empresa, asunto, mensaje |

---

## 6. Problemas del Legacy a Corregir

| # | Problema | Solución en Laravel |
|---|---|---|
| 1 | Landing: `From` no es un email válido → Spam | Usar `MAIL_FROM_ADDRESS` con email real |
| 2 | Landing: `mail()` sin SMTP | SMTP autenticado |
| 3 | CI: API Key de SocketLabs hardcodeada | Mover a `.env` |
| 4 | CI: `$_POST` sin sanitización | `$request->validate()` |
| 5 | Destinatarios hardcodeados en ambos sistemas | Tabla `email_contacts` en Filament |
| 6 | Sin confirmación al usuario | Email de confirmación al solicitante |
| 7 | Sin logs de envío | Usar Laravel queue + logs |
