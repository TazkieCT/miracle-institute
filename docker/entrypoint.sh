#!/bin/sh
set -e

APP_KEY_FILE="/var/www/html/storage/docker/app.key"

mkdir -p \
    /var/www/html/storage/docker \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

if [ -z "${APP_KEY:-}" ]; then
    if [ ! -f "$APP_KEY_FILE" ]; then
        php artisan key:generate --show > "$APP_KEY_FILE"
    fi

    export APP_KEY="$(cat "$APP_KEY_FILE")"
fi

if [ ! -L /var/www/html/public/storage ] && [ ! -e /var/www/html/public/storage ]; then
    php artisan storage:link
fi

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

exec "$@"
