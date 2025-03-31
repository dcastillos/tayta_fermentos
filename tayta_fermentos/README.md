# 🛒 Tienda Virtual - Saigotec

<img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain.svg" alt="Laravel" width="80" height="80"/>
<img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/vuejs/vuejs-original.svg" alt="Vue.js" width="80" height="80"/>
<img src="https://raw.githubusercontent.com/laravel/laravel.com/HEAD/assets/img/logomark.min.svg" alt="Laravel Mix" width="80" height="80"/>

## 📌 Descripción
Tienda virtual desarrollada con **Laravel** y **Vue.js**, con integración a un sistema de facturación para la emisión de comprobantes electrónicos (boletas y facturas). La tienda permite la gestión de productos, carrito de compras, pagos en línea y generación de documentos tributarios.

## 🚀 Tecnologías Implementadas
- **Laravel** - Framework PHP para el backend
- **Vue.js** - Framework JavaScript para el frontend
- **Laravel Mix** - Compilación de assets (CSS, JS)
- **Axios** - Peticiones HTTP
- **MySQL** - Base de datos
- **Bootstrap** - Diseño responsivo
- **Stripe / PayPal** - Integración de pagos en línea

## 📷 Capturas de Pantalla
### 🛍️ Página Principal
![Tienda Virtual](https://via.placeholder.com/800x400?text=Tienda+Virtual)

### 🛒 Carrito de Compras
![Carrito](https://via.placeholder.com/800x400?text=Carrito+de+Compras)

### 📄 Emisión de Facturas
![Factura](https://via.placeholder.com/800x400?text=Factura+Electronica)

## 📦 Instalación y Configuración
### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/usuario/tvirtualsaigotec.git
cd tvirtualsaigotec
```

### 2️⃣ Instalar dependencias
#### Backend (Laravel)
```bash
composer install
```
#### Frontend (Vue.js y Laravel Mix)
```bash
npm install
```

### 3️⃣ Configurar variables de entorno
Renombrar el archivo `.env.example` a `.env` y configurar las variables necesarias como la conexión a la base de datos, API keys, etc.
```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Migrar Base de Datos
```bash
php artisan migrate --seed
```

### 5️⃣ Compilar Assets
```bash
npm run dev  # Para desarrollo
npm run prod # Para producción
```

### 6️⃣ Levantar el servidor
```bash
php artisan serve
```
La aplicación estará disponible en `http://127.0.0.1:8000`

## 🔗 API para Integración con Sistema de Facturación
La tienda virtual está integrada con un sistema de facturación electrónica, permitiendo la emisión de boletas y facturas al finalizar la compra.

### 🔄 Endpoints principales
- **POST** `/api/cart/add` - Agregar producto al carrito
- **GET** `/api/cart` - Obtener los productos en el carrito
- **POST** `/api/order/create` - Generar una orden y emitir comprobante
- **GET** `/api/invoice/{id}` - Obtener detalle de una factura

## 👨‍💻 Autor
- **Nombre:** [Tu Nombre]
- **Empresa:** Saigotec
- **Sitio Web:** [https://saigotec.com](https://saigotec.com)

## 📜 Licencia
Este proyecto está bajo la licencia MIT.
