#!/bin/bash
set -e

# Update Apache port to match dynamic $PORT provided by Render/Cloud hosts
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf
fi

# Run database migrations automatically on boot
php artisan migrate --force || echo "Migrations completed or skipped."

# Optimize caches for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache web server in foreground
exec apache2-foreground
