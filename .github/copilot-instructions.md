# Copilot Instructions for EMS Laravel Application

## Project Overview
This is a Laravel 12 Employee Management System (EMS) built on a fresh Laravel skeleton with Vite/Tailwind frontend tooling. The application uses PHP 8.2+ with SQLite for local development and emphasizes clean architecture through service providers and dependency injection.

## Architecture & Key Components

### Directory Structure
- **`app/`** - Application logic (Models, Controllers, Providers). Use `App\` namespace.
  - `Models/User.php` - Base Eloquent model with factory support
  - `Providers/` - Service provider registration (minimal bootstrap needed)
- **`routes/web.php`** - Web routing (currently simple welcome page)
- **`database/`** - Migrations, factories, seeders
  - Migrations auto-run on setup; use `@php artisan make:migration` for new ones
  - Factories use `HasFactory` trait for seeders
- **`resources/`** - Frontend assets (CSS/JS) + Blade templates
  - `css/app.css` + `js/app.js` compiled via Vite
  - Tailwind 4.0 configured in `vite.config.js`
- **`tests/`** - Unit and Feature tests (PHPUnit 11+)

### Development Patterns

#### Models & Factories
- Models extend `Illuminate\Foundation\Auth\User` or `Illuminate\Database\Eloquent\Model`
- Use `HasFactory` trait and type-hint factories: `@use HasFactory<\Database\Factories\UserFactory>`
- Define `$fillable` for mass assignment safety
- Use `protected function casts(): array` for attribute casting (preferred over `$casts`)

#### Service Provider Usage
- Bootstrap services in `AppServiceProvider::boot()` or register in `register()`
- Keep providers focused; create new providers for domain-specific bootstrapping

#### Testing Setup
- Tests inherit from `Tests\TestCase` (extends Laravel's `TestCase`)
- Use SQLite in-memory DB for tests (`DB_DATABASE=:memory:` in phpunit.xml)
- Unit tests in `tests/Unit/`, Feature tests in `tests/Feature/`

## Workflows & Commands

### Development
```bash
# Full setup (installs PHP + NPM dependencies, generates APP_KEY, runs migrations)
composer run setup

# Run dev environment: PHP server + queue listener + log streaming + Vite dev server
composer run dev

# Individual commands:
php artisan serve                    # Start PHP server on :8000
npm run dev                          # Start Vite dev server
php artisan queue:listen --tries=1   # Listen to jobs (development mode)
php artisan pail --timeout=0         # Stream logs in real-time
```

### Testing
```bash
# Run all tests (clears config cache first)
composer run test

# Or directly:
php artisan test                     # Run Feature + Unit tests
php artisan test tests/Feature       # Run Feature tests only
php artisan test --filter=TestName   # Run specific test
```

### Database
```bash
php artisan migrate                  # Run pending migrations
php artisan migrate:fresh            # Reset and re-run all migrations
php artisan make:migration name      # Create new migration file
php artisan tinker                   # Interactive shell for DB queries/testing
```

### Code Quality
```bash
php artisan pint              # Fix code style (Laravel Pint)
php artisan config:clear      # Clear cached config (run before tests)
```

## Project-Specific Conventions

### Namespace & Autoloading
- PSR-4 namespace mapping: `App\` → `app/`, `Tests\` → `tests/`, `Database\` → `database/`
- All classes auto-discovered via Composer; run `composer dump-autoload` after structural changes

### Environment & Configuration
- `.env` file controls `APP_NAME`, `APP_DEBUG`, database, mail, etc.
- Configuration cached in `config/` and bootstrap files; clear with `php artisan config:clear`
- Database uses SQLite in development (`:memory:` in tests)

### Frontend
- Vite handles asset bundling; no traditional webpack required
- Tailwind CSS v4 configured for rapid utility-based styling
- Entry points: `resources/css/app.css` and `resources/js/app.js`
- Blade templates in `resources/views/` (e.g., `welcome.blade.php`)

### Authentication & Models
- `User` model uses `Authenticatable` trait from `Illuminate\Foundation\Auth`
- Password auto-cast to hash; `remember_token` hidden from serialization
- Email verification support commented out but available

## Integration Points

### Laravel Tinker (REPL)
- Run `php artisan tinker` to test models/queries: `User::factory()->create()`
- Quick prototyping without writing test files

### Database Seeders
- Located in `database/seeders/DatabaseSeeder.php`
- Call from seeders: `$this->call([UserSeeder::class])`
- Run with `php artisan db:seed`

### Third-party Packages
- **Laravel Pint**: Code formatting (`.pint.json` or built-in defaults)
- **Faker**: Test data generation via factories
- **Mockery**: Mocking in tests
- **Collision**: Enhanced error output
- **Laravel Sail**: Docker environment (optional, not configured here)

## Common Tasks for AI Agents

1. **Add a new resource**: Use `php artisan make:model Post -m -f -c` (creates Model, migration, factory, controller)
2. **Create tests**: Extend `Tests\TestCase`, use `$this->post('/route')` for HTTP tests
3. **Debug issues**: Use `php artisan tinker` to inspect data or `php artisan pail` for log streaming
4. **Migrate schema changes**: Create migration, define `up()` and `down()` methods, run `php artisan migrate`
5. **Check test coverage**: PHPUnit configured to analyze `app/` directory (see `phpunit.xml`)
