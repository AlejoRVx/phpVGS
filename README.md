<p align="center"><img src="public/logo.ico" alt="VGStorm Logo" width="100"></p>

<h1 align="center">VGStorm</h1>

<p align="center">
    Tienda en línea de videojuegos y consolas desarrollada con Laravel 12.
</p>

---

## Descripción

VGStorm es una plataforma de e-commerce enfocada en la venta de videojuegos digitales y consolas. Ofrece un catálogo público con búsqueda y filtros, un carrito de compras con persistencia en base de datos, un panel de administración completo y un sistema de noticias gestionables desde el admin.

### Funcionalidades principales

**Panel de usuario:**
- Catálogo de juegos y consolas con búsqueda en tiempo real
- Filtros por precio y ordenamiento
- Carrito de compras persistente (se mantiene al cerrar sesión)
- Checkout con múltiples métodos de pago
- Historial de pedidos y facturas
- Sistema de reseñas y calificaciones
- Gestión de perfil y eliminación de cuenta
- Página principal con noticias y top de ventas

**Panel de administración:**
- Dashboard con métricas (usuarios, productos, pedidos, ventas)
- CRUD de productos (juegos y consolas) con drag & drop de imágenes
- CRUD de noticias con drag & drop de imágenes
- Gestión de usuarios (editar rol, eliminar)
- Últimos pedidos recientes

---

## Stack tecnológico

| Componente | Tecnología |
|---|---|
| Backend | Laravel 12.37 |
| Frontend | Blade + Tailwind CSS v4 |
| Build | Vite 7 |
| Base de datos | MySQL |
| PHP | 8.2+ |
| Node.js | 18+ |

---

## Requisitos previos

- PHP 8.2 o superior
- Composer
- Node.js 18+ y npm
- MySQL
- n8n (opcional, para notificaciones)

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd VGStorm
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar el archivo `.env` con las credenciales de tu base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vgstorm
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Crear la base de datos

```sql
CREATE DATABASE vgstorm;
```

### 5. Ejecutar migraciones

```bash
php artisan migrate
```

### 6. Ejecutar semillas

```bash
php artisan db:seed
```

### 7. Crear enlace de storage (imágenes)

```bash
php artisan storage:link
```

> **Nota:** Este paso es obligatorio para que las imágenes subidas en noticias y productos sean visibles.

### 8. Correr el proyecto

En una terminal:
```bash
php artisan serve
```

En otra terminal:
```bash
npm run dev
```

El proyecto estará disponible en `http://localhost:8000`.

---

## Estructura del proyecto

```
VGStorm/
├── app/
│   ├── Domain/Cart/          # Lógica de dominio del carrito
│   ├── Http/
│   │   ├── Controllers/      # Controllers públicos
│   │   ├── Controllers/Admin/ # Controllers del panel admin
│   │   ├── Middleware/        # Middleware (AdminMiddleware)
│   │   └── Requests/         # Form Requests (validación)
│   ├── Models/               # Modelos Eloquent
│   ├── Repositories/         # Capa de acceso a datos
│   └── Services/             # Lógica de negocio
│       ├── Admin/            # Dashboard, productos admin
│       ├── Catalogo/         # Catálogo público
│       ├── Noticias/         # CRUD noticias
│       ├── Pedidos/          # Checkout
│       └── Usuarios/         # Registro, perfil, recuperación
├── database/migrations/      # Migraciones de la BD
├── resources/
│   ├── css/app.css           # Estilos Tailwind v4
│   ├── js/app.js             # JavaScript (vanilla)
│   └── views/
│       ├── layouts/          # Layouts (app, admin)
│       ├── admin/            # Vistas del admin
│       └── *.blade.php       # Vistas públicas
└── routes/web.php            # Rutas
```

---

## Arquitectura

El proyecto sigue una arquitectura por capas:

- **Controllers** → Delgados, delegan toda la lógica a services
- **Services** → Contienen la lógica de negocio
- **Repositories** → Acceso a datos y consultas
- **Models** → Definición de tablas y relaciones
- **FormRequests** → Validación declarativa
- **Domain** → Lógica de dominio (carrito)

---

## Rutas principales

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/` | Redirige a `/main` |
| GET | `/main` | Página principal |
| GET | `/productos/juegos` | Catálogo de juegos |
| GET | `/productos/consolas` | Catálogo de consolas |
| GET | `/productos/{id}/resenas` | Detalle y reseñas |
| GET | `/login` | Inicio de sesión |
| GET | `/register` | Registro |
| GET | `/perfil` | Mi perfil |
| GET | `/pedidos` | Carrito de compras |
| GET | `/pagos` | Checkout |
| GET | `/mis-pedidos` | Historial de pedidos |
| GET | `/admin/dashboard` | Panel de administración |
| GET | `/admin/productos` | Gestión de productos |
| GET | `/admin/noticias` | Gestión de noticias |
| GET | `/admin/usuarios` | Gestión de usuarios |

---

## Usuarios de prueba

Para acceder al panel de admin, necesitas un usuario con `rol_id = 2` en la tabla `usuarios`.

---

## Licencia

Proyecto desarrollado con fines académicos.
