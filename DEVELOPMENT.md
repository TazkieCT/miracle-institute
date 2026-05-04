# Development Setup with Hot Reload

This guide explains how to run the Miracle Institute project in development mode with hot reload for both backend and frontend.

## Prerequisites

- Docker Desktop installed and running
- Terminal/PowerShell access

## Getting Started

### 1. Start the Development Environment

```bash
docker compose -f docker-compose.dev.yml up -d
```

This will start:
- **App Service** (Port 8000): Laravel development server with code watching
- **Vite Service** (Port 5173): Frontend dev server with HMR (Hot Module Replacement)
- **Database Service** (Port 3306): MySQL database
- **PhpMyAdmin** (Port 8080): Database management UI

### 2. Access Your Application

- **Application**: http://localhost:8000
- **Vite Dev Server**: http://localhost:5173 (automatically used by Laravel Vite plugin)
- **PhpMyAdmin**: http://localhost:8080

## What's Included

### Hot Reload Features

#### Backend (PHP/Laravel)
- Full source code mounted as a volume
- Laravel development server with file watching
- Changes to PHP files are reflected immediately

#### Frontend (Vite)
- Frontend assets mounted as a volume
- Vite dev server with HMR enabled
- CSS, JavaScript, and Vue component changes hot-reload in the browser
- No manual refresh needed in most cases

### Development Environment

The dev compose file mounts your local source code directly into the container, so:
- Edit files in your IDE normally
- Changes appear instantly in the running container
- Database persists across restarts
- Logs are streamed to your terminal

## Running Commands

### Run Artisan Commands

```bash
docker compose -f docker-compose.dev.yml exec app php artisan <command>
```

Examples:
```bash
# Run migrations
docker compose -f docker-compose.dev.yml exec app php artisan migrate

# Create a new model
docker compose -f docker-compose.dev.yml exec app php artisan make:model ModelName

# Clear cache
docker compose -f docker-compose.dev.yml exec app php artisan cache:clear
```

### Run Composer Commands

```bash
docker compose -f docker-compose.dev.yml exec app composer <command>
```

### Run npm Commands

```bash
docker compose -f docker-compose.dev.yml exec vite npm <command>
```

## Viewing Logs

### App Logs
```bash
docker compose -f docker-compose.dev.yml logs -f app
```

### Vite Logs (Frontend)
```bash
docker compose -f docker-compose.dev.yml logs -f vite
```

### Database Logs
```bash
docker compose -f docker-compose.dev.yml logs -f db
```

## Stopping Development

```bash
docker compose -f docker-compose.dev.yml down
```

To also remove volumes (clean slate next time):
```bash
docker compose -f docker-compose.dev.yml down -v
```

## Troubleshooting

### Port Already in Use
If ports 8000, 5173, 3306, or 8080 are already in use, modify the compose file or stop conflicting services.

### HMR Not Working
- Ensure Vite service is running: `docker compose -f docker-compose.dev.yml ps`
- Check Vite logs: `docker compose -f docker-compose.dev.yml logs vite`
- Verify `VITE_HMR_HOST` and `VITE_HMR_PORT` in the compose file match your local setup

### Database Connection Issues
- Verify all services are running: `docker compose -f docker-compose.dev.yml ps`
- Check database logs: `docker compose -f docker-compose.dev.yml logs db`
- Ensure `.env` or compose environment variables have correct credentials

## Tips

- Use `tail -f docker-compose-dev.logs` after redirecting output: `docker compose -f docker-compose.dev.yml up -d > docker-compose-dev.logs 2>&1`
- Most IDE extensions work seamlessly with Docker development setups
- Storage/cache volumes are preserved between restarts but mounted as separate volumes
