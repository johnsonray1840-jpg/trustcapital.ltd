#!/bin/bash
set -e

# Configure Apache port dynamically if PORT is provided by Render
if [ -n "$PORT" ]; then
    sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
    sed -i "s/:80/:$PORT/" /etc/apache2/sites-available/000-default.conf
fi

# Ensure storage directories exist and are writable
mkdir -p /var/www/html/core/storage/framework/cache/data \
         /var/www/html/core/storage/framework/sessions \
         /var/www/html/core/storage/framework/views \
         /var/www/html/core/storage/logs \
         /var/www/html/core/bootstrap/cache

chown -R www-data:www-data /var/www/html/core/storage /var/www/html/core/bootstrap/cache /var/www/html/assets
chmod -R 775 /var/www/html/core/storage /var/www/html/core/bootstrap/cache

# Clear and cache configurations
cd /var/www/html/core
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

exec apache2-foreground
