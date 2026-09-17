#!/bin/sh

set -eu

if [ ! -f .env ]; then
    cp .env.example .env
fi

mkdir -p database
touch "${DB_DATABASE:-database/database.sqlite}"

if [ -z "${APP_KEY:-}" ] || ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

# Seed only if the database has never been migrated (no migrations table yet).
if php artisan migrate:status 2>&1 | grep -q 'Migration table not found'; then
    php artisan migrate --seed --force
else
    php artisan migrate --force
fi

exec php artisan serve --host=0.0.0.0 --port=8000
