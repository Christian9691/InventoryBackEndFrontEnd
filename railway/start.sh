
#!/bin/sh
set -e

echo "Preparing SQLite database..."

mkdir -p /data
touch /data/database.sqlite

php artisan migrate --force

php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "Starting Laravel..."

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
