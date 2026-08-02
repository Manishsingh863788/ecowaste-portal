#!/bin/bash
set -e

# Update Apache port to match dynamic $PORT provided by Render
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf
fi

# Ensure storage subdirectories exist with proper permissions
mkdir -p storage/framework/views \
         storage/framework/sessions \
         storage/framework/cache/data \
         storage/logs \
         bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Ensure valid base64 APP_KEY exists
if [[ -z "$APP_KEY" || "$APP_KEY" != base64:* ]]; then
    echo "Generating new production APP_KEY..."
    php artisan key:generate --force
fi

# Clear any stale configuration caches before running migrations
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run database migrations
php artisan migrate --force || echo "Migration notice: could not complete migrations."

# Cache configuration, routes, and views for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache web server
exec apache2-foreground
