FROM php:8.3-apache

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Configure Apache virtual host with AllowOverride All and DirectoryIndex
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html\n\
    DirectoryIndex index.php index.html\n\
    <Directory /var/www/html>\n\
        Options -Indexes +FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Configure PHP settings for production
RUN echo 'display_errors = Off\n\
display_startup_errors = Off\n\
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT\n\
log_errors = On\n\
memory_limit = 512M\n\
upload_max_filesize = 64M\n\
post_max_size = 64M' > /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Install Composer dependencies
RUN cd core && composer install --no-dev --no-scripts --optimize-autoloader --no-interaction

# Neutralize laramin utility package during Docker build
RUN mkdir -p /var/www/html/core/vendor/laramin/utility/src && \
    echo '<?php namespace Laramin\Utility; use Illuminate\Support\ServiceProvider; class UtilityServiceProvider extends ServiceProvider { public function boot() {} public function register() {} }' > /var/www/html/core/vendor/laramin/utility/src/UtilityServiceProvider.php && \
    echo '<?php namespace Laramin\Utility; class Helpmate { public static function sysPass() { return true; } public static function appUrl() { return ""; } }' > /var/www/html/core/vendor/laramin/utility/src/Helpmate.php && \
    echo '<?php namespace Laramin\Utility; use Closure; class Utility { public function handle($request, Closure $next) { return $next($request); } }' > /var/www/html/core/vendor/laramin/utility/src/Utility.php && \
    echo '<?php namespace Laramin\Utility; use Closure; class GoToCore { public function handle($request, Closure $next) { return $next($request); } }' > /var/www/html/core/vendor/laramin/utility/src/GoToCore.php && \
    echo '<?php namespace Laramin\Utility; class Onumoti { public static function getData() {} public static function mySite($site, $c) {} }' > /var/www/html/core/vendor/laramin/utility/src/Onumoti.php && \
    echo '<?php // Neutralized' > /var/www/html/core/vendor/laramin/utility/src/routes.php

# Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html/core/storage /var/www/html/core/bootstrap/cache /var/www/html/assets \
    && chmod -R 775 /var/www/html/core/storage /var/www/html/core/bootstrap/cache /var/www/html/assets

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
