# JWT Token Based Laravel Auth

This repository contains a Laravel project implementing JSON Web Token (JWT) based authentication. JWT is a widely used standard for secure authentication and authorization in web applications. This project serves as a starting point for building a Laravel application with JWT-based authentication.

## Features

- **JWT Authentication:** Secure user authentication using JSON Web Tokens.
- **User Registration:** API endpoint for user registration with validation.
- **User Login:** API endpoint for user login and token generation.
- **Token Refresh:** API endpoint to refresh an expired JWT token.
- **User Profile:** API endpoint to fetch and update user profile information.
- **Middleware:** Middleware for authenticating requests using JWT.

## Prerequisites

Before getting started, ensure you have the following installed:

- PHP (>= 8)
- Composer
- Laravel (>= 10.x)
- MySQL or other compatible database

## Installation

1. Clone the repository:

```bash
git clone https://github.com/seo-asif/JWT-Token-Laravel.git
```

2. Navigate to the project directory:

```bash
cd jwt-token-based-laravel-auth
```

3. Install dependencies:

```bash
composer install
```

4. Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

5. Configure your database and JWT settings in the `.env` file.

6. Run database migrations:

```bash
php artisan migrate
```

7. Generate the application key:

```bash
php artisan key:generate
```

8. Start the development server:

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser to see the application.

## API Documentation

For detailed API documentation and usage examples, refer to the [API Documentation](docs/api.md).

## Contributing

If you would like to contribute to this project, please follow the [Contributing Guidelines](CONTRIBUTING.md).

## License

This project is open-source and available under the [MIT License](LICENSE).


