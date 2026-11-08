#!/bin/bash
set -e

# Configure Apache port dynamically if PORT is provided by Render
if [ -n "$PORT" ]; then
    echo "Configuring Apache port to $PORT..."
    sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:$PORT>/" /etc/apache2/sites-available/000-default.conf
fi

# Ensure storage directories exist and are fully writable by www-data
mkdir -p /var/www/html/core/storage/framework/cache/data \
         /var/www/html/core/storage/framework/sessions \
         /var/www/html/core/storage/framework/views \
         /var/www/html/core/storage/logs \
         /var/www/html/core/bootstrap/cache

# Remove any install directory if present
rm -rf /var/www/html/install

# Generate /var/www/html/core/.env from environment variables
echo "Generating core/.env..."
cat <<ENVEOF > /var/www/html/core/.env
APP_NAME="${APP_NAME:-TrustCapital}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY:-base64:X6p1ECyLlIo/hhHnBBjbLbmWY3lU7n7v9YyWdJ2H4fs=}"
APP_DEBUG=true
APP_URL="${APP_URL:-https://trustcapitals.ltd}"

LOG_CHANNEL=errorlog

DB_CONNECTION="${DB_CONNECTION:-mysql}"
DB_HOST="${DB_HOST:-mysql-trustcapitalwiz-michaelraymond1840-4a99.b.aivencloud.com}"
DB_PORT="${DB_PORT:-18509}"
DB_DATABASE="${DB_DATABASE:-defaultdb}"
DB_USERNAME="${DB_USERNAME:-avnadmin}"
DB_PASSWORD="${DB_PASSWORD:-AVNS_K4LWDHk-u14QYebzxop}"

BROADCAST_CONNECTION=log
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
CACHE_STORE=file
CACHE_DRIVER=file
SESSION_LIFETIME=120
ENVEOF

# Clear caches before changing permissions so root does not create unreadable cache files
cd /var/www/html/core
php artisan package:discover --ansi || true
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# Grant full ownership and 777 permissions to storage so www-data can create subfolders and files
chown -R www-data:www-data /var/www/html/core/storage /var/www/html/core/bootstrap/cache /var/www/html/assets /var/www/html/core/.env
chmod -R 777 /var/www/html/core/storage /var/www/html/core/bootstrap/cache

exec apache2-foreground
