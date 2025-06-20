# CRUD de Usuarios - Laravel API

Este proyecto es una API RESTful desarrollada en Laravel para la gestión de usuarios. Permite crear, leer, actualizar, eliminar usuarios y obtener estadísticas por dominio de email.

## 📦 Requisitos

-   PHP >= 8.2
-   Composer
-   MySQL o cualquier base de datos compatible
-   Node.js y NPM (opcional si se usa frontend)

## ⚙️ Instalación

1. Clona el repositorio:

    ```bash
    git clone https://github.com/usuario/crud-usuarios.git
    cd crud-usuarios
    ```

2. Instala las dependencias:

    ```bash
    composer install
    ```

3. Copia el archivo `.env` y configura tu base de datos:

    ```bash
    cp .env.example .env
    ```

4. Genera la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

5. Crea la base de datos y corre las migraciones:

    ```bash
    php artisan migrate
    ```

6. Llena la base de datos con datos falsos:

    ```bash
    php artisan db:seed
    ```

7. Levanta el servidor:

    ```bash
    php artisan serve
    ```

## 🔁 Endpoints de la API

Todos los endpoints están prefijados con `/api`.

### 📄 Listar usuarios

-   **GET** `/api/users`
-   Requiere autenticación

### ➕ Crear usuario

-   **POST** `/api/users`
-   Requiere autenticación
-   Body (JSON):

    ```json
    {
        "name": "Juan",
        "email": "juan@example.com",
        "password": "secreto123"
    }
    ```

### 🔍 Ver usuario por ID

-   **GET** `/api/users/{id}`
-   Requiere autenticación

### ✏️ Actualizar usuario

-   **PUT** `/api/users/{id}`
-   Requiere autenticación
-   Body (JSON):

    ```json
    {
        "name": "Juan Actualizado",
        "email": "nuevo@example.com",
        "password": "nuevo123"
    }
    ```

### ❌ Eliminar usuario

-   **DELETE** `/api/users/{id}`
-   Requiere autenticación

### 📊 Top 3 dominios de email

-   **GET** `/api/users/top-domains`
-   Requiere autenticación
-   Devuelve los tres dominios de email más frecuentes entre los usuarios en orden descendente.

## 🔐 Autenticación (Laravel Sanctum)

Esta API utiliza [Laravel Sanctum](https://laravel.com/docs/sanctum) para autenticar las rutas protegidas. Debes registrarte o iniciar sesión para obtener un token.

### 1. Registro de usuario

-   **POST** `/api/register`
-   Body:

    ```json
    {
        "name": "Juan",
        "email": "juan@example.com",
        "password": "secreto123",
        "password_confirmation": "secreto123"
    }
    ```

-   Respuesta:

    ```json
    {
        "token": "2|abcd...tu_token"
    }
    ```

### 2. Login

-   **POST** `/api/login`
-   Body:

    ```json
    {
        "email": "juan@example.com",
        "password": "secreto123"
    }
    ```

-   Respuesta:

    ```json
    {
        "token": "2|abcd...tu_token"
    }
    ```

### 3. Usar el token

Para acceder a rutas protegidas, añade los siguientes headers en Postman:

-   `Authorization: Bearer TU_TOKEN`
-   `Accept: application/json`

### 4. Rutas protegidas

Estas rutas requieren estar autenticado:

-   `GET /api/users`
-   `POST /api/users`
-   `GET /api/users/{id}`
-   `PUT /api/users/{id}`
-   `DELETE /api/users/{id}`
-   `GET /api/users/top-domains`

Si no se envía un token válido, la API responderá con:

```json
{
    "message": "Unauthenticated."
}
```
