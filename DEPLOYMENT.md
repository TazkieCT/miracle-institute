# Deployment Guide

This project is set up for manual Docker-based deployment with no CI/CD.

## What is included

- `docker-compose.yml` for a production-oriented stack
- `Dockerfile` using `php-fpm` for Laravel
- nginx in front of PHP-FPM
- dedicated queue worker and scheduler containers
- MySQL container for single-server deployment
- PHP production settings and OPCache enabled

## Services

- `nginx`: public web server
- `app`: Laravel application running on PHP-FPM
- `queue-worker`: processes queued jobs
- `scheduler`: runs `php artisan schedule:run` every minute
- `db`: MySQL 8

## Server requirements

- Docker Engine
- Docker Compose plugin
- a Linux VPS or server
- a domain name pointed to the server

## First-time setup

1. Copy the project to your server.
2. Copy `.env.production.example` to `.env`.
3. Update every placeholder value in `.env`, especially:
   - `APP_URL`
   - `APP_KEY`
   - `DB_PASSWORD`
   - `DB_ROOT_PASSWORD`
   - mail settings
   - Google API settings
4. Generate an application key if you do not want the container to auto-generate one:

```bash
docker compose run --rm app php artisan key:generate --show
```

5. Put the generated value into `.env` as `APP_KEY=...`.

## Deploy

Build and start the stack:

```bash
docker compose up -d --build
```

Run database migrations:

```bash
docker compose exec app php artisan migrate --force
```

Cache Laravel for production:

```bash
docker compose exec app php artisan config:cache
docker compose exec app php artisan view:cache
docker compose exec app php artisan route:cache
```

If `route:cache` fails because a route uses a Closure, skip that command.

## Updates

After pulling new code to the server:

```bash
docker compose up -d --build
docker compose exec app php artisan migrate --force
docker compose exec app php artisan config:cache
docker compose exec app php artisan view:cache
```

## Useful commands

View logs:

```bash
docker compose logs -f nginx
docker compose logs -f app
docker compose logs -f queue-worker
docker compose logs -f scheduler
```

Open a shell inside the app container:

```bash
docker compose exec app sh
```

Restart services:

```bash
docker compose restart
```

Stop the stack:

```bash
docker compose down
```

## HTTPS

This stack exposes nginx on port 80. For HTTPS, put the server behind:

- a host-level nginx reverse proxy with Let's Encrypt, or
- a gateway like Traefik or Caddy

If you want, we can add one of those next.

## Notes

- `docker-compose.dev.yml` remains the development setup.
- `docker-compose.yml` is now intended for deployment.
- `RUN_MIGRATIONS=true` is available, but manual migration is safer for production.
