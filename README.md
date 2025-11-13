# Modular ERP System - Laravel API

A commercial-grade, modular, and scalable Laravel API project designed for ERP systems. This project implements a fully modular architecture where each module is self-contained, independently installable, and auto-registered by the system.

## Features

- **Modular Architecture**: Self-contained modules under `modules/` directory
- **Dynamic Module Loading**: Automatic discovery and registration of modules
- **API-Only Mode**: Standardized JSON responses
- **Repository + Service Pattern**: Clean separation of concerns
- **PSR-12 Compliant**: Follows PHP coding standards
- **Multi-Tenancy Ready**: Structured for SaaS deployment
- **Redis & Queue Ready**: Built for scalability
- **Docker Compatible**: Ready for containerized deployment

## Requirements

- PHP 8.1 or higher
- Composer
- Laravel 10.x
- SQLite/MySQL/PostgreSQL

## Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd <project-directory>
```

2. **Install dependencies**
```bash
composer install
```

3. **Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database**

For SQLite (default):
```bash
touch database/database.sqlite
```

Update `.env`:
```env
DB_CONNECTION=sqlite
```

For MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run migrations**
```bash
php artisan migrate
```

6. **Start the development server**
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## Project Structure

```
.
├── app/
│   └── Providers/
│       └── ModuleServiceProvider.php    # Dynamic module loader
├── config/
│   └── modules.php                      # Module configuration
├── modules/
│   ├── Core/                           # Core module (base functionality)
│   │   ├── Contracts/
│   │   │   ├── RepositoryInterface.php
│   │   │   └── ServiceInterface.php
│   │   ├── Http/
│   │   │   └── Controllers/
│   │   │       └── BaseController.php
│   │   ├── Providers/
│   │   │   └── CoreServiceProvider.php
│   │   ├── Repositories/
│   │   │   └── BaseRepository.php
│   │   ├── Routes/
│   │   │   └── api.php
│   │   ├── Services/
│   │   │   └── BaseService.php
│   │   └── Traits/
│   │       └── ApiResponseTrait.php
│   └── HR/                             # HR module (Human Resource)
│       ├── Database/
│       │   └── Migrations/
│       │       └── 2025_01_01_000001_create_divisions_table.php
│       ├── Http/
│       │   ├── Controllers/
│       │   │   └── DivisionController.php
│       │   └── Requests/
│       │       ├── StoreDivisionRequest.php
│       │       └── UpdateDivisionRequest.php
│       ├── Models/
│       │   └── Division.php
│       ├── Providers/
│       │   └── HRServiceProvider.php
│       ├── Repositories/
│       │   └── DivisionRepository.php
│       ├── Routes/
│       │   └── api.php
│       └── Services/
│           └── DivisionService.php
└── composer.json
```

## Modules

### Core Module

The Core module provides base functionality for all other modules:

- **BaseController**: Base controller with API response helpers
- **BaseRepository**: Base repository implementing CRUD operations
- **BaseService**: Base service layer for business logic
- **ApiResponseTrait**: Standardized JSON response methods
- **Interfaces**: ServiceInterface and RepositoryInterface

### HR Module (Human Resource)

The HR module manages human resource data, starting with divisions.

**Division Management Features:**
- Create, Read, Update, Delete divisions
- Soft delete support
- Active/Inactive status
- Unique division codes
- Comprehensive validation

## API Endpoints

### HR - Division Management

Base URL: `/api/v1/hr`

#### List all divisions
```http
GET /api/v1/hr/divisions
```

Response:
```json
{
    "success": true,
    "message": "Divisions retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Information Technology",
            "code": "IT",
            "description": "IT Department",
            "is_active": true,
            "created_at": "2025-01-01T00:00:00.000000Z",
            "updated_at": "2025-01-01T00:00:00.000000Z",
            "deleted_at": null
        }
    ]
}
```

#### Get active divisions only
```http
GET /api/v1/hr/divisions/active
```

#### Get a specific division
```http
GET /api/v1/hr/divisions/{id}
```

#### Create a new division
```http
POST /api/v1/hr/divisions
Content-Type: application/json

{
    "name": "Information Technology",
    "code": "IT",
    "description": "IT Department",
    "is_active": true
}
```

Response (201 Created):
```json
{
    "success": true,
    "message": "Division created successfully",
    "data": {
        "id": 1,
        "name": "Information Technology",
        "code": "IT",
        "description": "IT Department",
        "is_active": true,
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z",
        "deleted_at": null
    }
}
```

#### Update a division
```http
PUT /api/v1/hr/divisions/{id}
Content-Type: application/json

{
    "name": "Information Technology Updated",
    "description": "Updated description"
}
```

#### Delete a division
```http
DELETE /api/v1/hr/divisions/{id}
```

Response:
```json
{
    "success": true,
    "message": "Division deleted successfully",
    "data": null
}
```

## Creating a New Module

Follow these steps to create a new module:

### 1. Create Module Structure

```bash
mkdir -p modules/YourModule/{Http/Controllers,Http/Requests,Models,Providers,Routes,Services,Repositories,Database/Migrations}
```

### 2. Create Service Provider

Create `modules/YourModule/Providers/YourModuleServiceProvider.php`:

```php
<?php

namespace Modules\YourModule\Providers;

use Illuminate\Support\ServiceProvider;

class YourModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register bindings
    }

    public function boot(): void
    {
        $this->loadMigrations();
        $this->loadRoutes();
    }

    protected function loadMigrations(): void
    {
        $migrationPath = __DIR__ . '/../Database/Migrations';
        if (is_dir($migrationPath)) {
            $this->loadMigrationsFrom($migrationPath);
        }
    }

    protected function loadRoutes(): void
    {
        $routePath = __DIR__ . '/../Routes/api.php';
        if (file_exists($routePath)) {
            $this->loadRoutesFrom($routePath);
        }
    }
}
```

### 3. Create Routes

Create `modules/YourModule/Routes/api.php`:

```php
<?php

use Illuminate\Support\Facades\Route;
use Modules\YourModule\Http\Controllers\YourController;

Route::prefix('api/v1/your-module')->group(function () {
    Route::apiResource('resources', YourController::class);
});
```

### 4. Create Model

Create `modules/YourModule/Models/YourModel.php`:

```php
<?php

namespace Modules\YourModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YourModel extends Model
{
    use SoftDeletes;

    protected $fillable = ['field1', 'field2'];
}
```

### 5. Create Repository

Create `modules/YourModule/Repositories/YourRepository.php`:

```php
<?php

namespace Modules\YourModule\Repositories;

use Modules\Core\Repositories\BaseRepository;
use Modules\YourModule\Models\YourModel;

class YourRepository extends BaseRepository
{
    public function __construct(YourModel $model)
    {
        parent::__construct($model);
    }
}
```

### 6. Create Service

Create `modules/YourModule/Services/YourService.php`:

```php
<?php

namespace Modules\YourModule\Services;

use Modules\Core\Services\BaseService;
use Modules\YourModule\Repositories\YourRepository;

class YourService extends BaseService
{
    public function __construct(YourRepository $repository)
    {
        parent::__construct($repository);
    }
}
```

### 7. Create Controller

Create `modules/YourModule/Http/Controllers/YourController.php`:

```php
<?php

namespace Modules\YourModule\Http\Controllers;

use Modules\Core\Http\Controllers\BaseController;
use Modules\YourModule\Services\YourService;

class YourController extends BaseController
{
    protected YourService $service;

    public function __construct(YourService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->getAll();
        return $this->successResponse($data);
    }
}
```

### 8. Register the Module

Add your module to `config/modules.php`:

```php
'modules' => [
    'Core',
    'HR',
    'YourModule', // Add your module here
],
```

### 9. Update Composer Autoload

```bash
composer dump-autoload
```

### 10. Create and Run Migrations

```bash
php artisan migrate
```

## Standardized JSON Response Format

All API responses follow this structure:

### Success Response
```json
{
    "success": true,
    "message": "Operation successful",
    "data": { }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": { }
}
```

### Validation Error Response (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "field_name": ["Error message"]
    }
}
```

## Testing the API

### Using cURL

**Create a Division:**
```bash
curl -X POST http://localhost:8000/api/v1/hr/divisions \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Information Technology",
    "code": "IT",
    "description": "IT Department",
    "is_active": true
  }'
```

**Get All Divisions:**
```bash
curl -X GET http://localhost:8000/api/v1/hr/divisions \
  -H "Accept: application/json"
```

**Get a Specific Division:**
```bash
curl -X GET http://localhost:8000/api/v1/hr/divisions/1 \
  -H "Accept: application/json"
```

**Update a Division:**
```bash
curl -X PUT http://localhost:8000/api/v1/hr/divisions/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "IT Department Updated",
    "description": "Updated description"
  }'
```

**Delete a Division:**
```bash
curl -X DELETE http://localhost:8000/api/v1/hr/divisions/1 \
  -H "Accept: application/json"
```

### Using Postman

1. Import the API endpoints into Postman
2. Set base URL: `http://localhost:8000`
3. Add header: `Accept: application/json`
4. For POST/PUT requests, add header: `Content-Type: application/json`

## Architecture Patterns

### Repository Pattern
Repositories handle all database operations, providing a clean abstraction layer between the data layer and business logic.

### Service Pattern
Services contain business logic and use repositories to interact with the database. Controllers should remain thin and delegate to services.

### Dependency Injection
All dependencies are injected through constructors, making the code testable and following SOLID principles.

## Configuration

### Module Configuration

Edit `config/modules.php` to:
- Enable/disable modules
- Configure module paths
- Enable auto-discovery

```php
return [
    'modules' => [
        'Core',
        'HR',
        // Add more modules here
    ],
    'namespace' => 'Modules',
    'path' => base_path('modules'),
    'auto_discovery' => true,
];
```

## Best Practices

1. **Follow PSR-12**: Maintain consistent coding standards
2. **Use Type Hints**: Always use type hints for parameters and return types
3. **Validation**: Use Form Request classes for validation
4. **Dependency Injection**: Inject dependencies through constructors
5. **Single Responsibility**: Keep classes focused on one responsibility
6. **Consistent Naming**: Follow Laravel naming conventions
7. **Documentation**: Document complex business logic
8. **Error Handling**: Use try-catch blocks and return appropriate responses

## Multi-Tenancy Support

The architecture is ready for multi-tenancy implementation:

1. Add `tenant_id` to models
2. Use global scopes for automatic tenant filtering
3. Configure tenant resolution middleware
4. Use separate databases or shared database with tenant_id

## Deployment

### Docker Deployment

Create a `Dockerfile`:

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
```

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure proper database credentials
- [ ] Set up Redis for caching and queues
- [ ] Configure queue workers
- [ ] Set up SSL/TLS
- [ ] Enable CORS if needed
- [ ] Set up monitoring and logging
- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`

## Troubleshooting

### Composer Autoload Issues
```bash
composer dump-autoload
```

### Migration Issues
```bash
php artisan migrate:fresh  # Warning: This drops all tables
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues, questions, or contributions, please refer to the project repository.

## Roadmap

- [ ] Authentication module (JWT/Sanctum)
- [ ] User management in Core module
- [ ] HR: Employee management
- [ ] HR: Department management
- [ ] HR: Attendance system
- [ ] Finance module
- [ ] Inventory module
- [ ] CRM module
- [ ] Reporting module
- [ ] Multi-tenancy implementation
- [ ] API documentation (Swagger/OpenAPI)
- [ ] Unit and Feature tests
- [ ] CI/CD pipeline

---

**Built with Laravel 10.x** | **Modular Architecture** | **Production Ready**
