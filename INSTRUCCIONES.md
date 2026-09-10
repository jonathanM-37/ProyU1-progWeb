# Tienda en Línea – Guía de Ejecución con Laragon y ngrok

## Estructura del proyecto

```
Tienda/
├── index.php        ← Pantalla de login
├── login.php        ← Procesador de credenciales PHP
├── dashboard.php    ← Dashboard del administrador
├── catalogo.php     ← Catálogo de productos (cliente)
├── error.php        ← Página de error (credenciales inválidas)
├── logout.php       ← Cerrar sesión
└── img/             ← Carpeta de imágenes de productos
    ├── audifonos.jpg
    ├── smartwatch.jpg
    ├── teclado.jpg
    ├── bocina.jpg
    └── mouse.jpg
```

---

## Paso 1 – Copiar el proyecto a Laragon

1. Abre **Laragon** y asegúrate de que esté corriendo (botón **Start All**).
2. Copia toda la carpeta `Tienda` dentro de:
   ```
   C:\laragon\www\Tienda
   ```
3. Verifica que la ruta quede:
   ```
   C:\laragon\www\Tienda\index.php
   ```

---

## Paso 2 – Verificar PHP activo

- En Laragon, haz clic en **Menu → PHP** y asegúrate de tener una versión ≥ 7.4.
- Abre tu navegador y visita:
  ```
  http://localhost/Tienda/
  ```
  Deberías ver la pantalla de **Inicio de Sesión**.

---

## Paso 3 – Agregar las imágenes de productos

Coloca los siguientes archivos en `C:\laragon\www\Tienda\img\`:

| Archivo          | Producto               |
|------------------|------------------------|
| `audifonos.jpg`  | Audífonos Bluetooth Pro |
| `smartwatch.jpg` | Smartwatch Serie 5     |
| `teclado.jpg`    | Teclado Mecánico RGB   |
| `bocina.jpg`     | Bocina Portátil 360°   |
| `mouse.jpg`      | Mouse Gaming 16000 DPI |

> Si alguna imagen no existe, el sistema mostrará un ícono de imagen en su lugar (no rompe la aplicación).

---

## Paso 4 – Exponer con ngrok

1. Descarga **ngrok** desde https://ngrok.com/download e instálalo.
2. Registra tu token (solo la primera vez):
   ```bash
   ngrok config add-authtoken TU_TOKEN_AQUI
   ```
3. Abre una **terminal** (PowerShell o CMD) y ejecuta:
   ```bash
   ngrok http 80
   ```
4. ngrok mostrará una URL pública, por ejemplo:
   ```
   Forwarding  https://abc123.ngrok-free.app -> http://localhost:80
   ```
5. Accede al proyecto con esa URL + la ruta:
   ```
   https://abc123.ngrok-free.app/Tienda/
   ```

---

## Credenciales de acceso

| Usuario        | Contraseña | Tipo           | Redirige a       |
|----------------|------------|----------------|------------------|
| administrador  | asd        | Administrador  | dashboard.php    |
| cliente        | 123        | Cliente        | catalogo.php     |

---

## Notas adicionales

- El proyecto **no usa base de datos**; todo es en memoria/archivos PHP.
- Las sesiones PHP se gestionan con `session_start()`.
- Si cierras el navegador, la sesión se pierde y deberás iniciar sesión nuevamente.
- Para cerrar sesión usa el botón **Salir** en la barra de navegación.
