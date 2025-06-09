#!/bin/sh

# Fail fast
set -e

echo "Waiting for the database to start..."

# Wait for MySQL to become available
until mysqladmin ping -h"$DB_HOST" --silent; do
  sleep 2
done

echo "Database started!"

# Install dependencies (if container is recreated without cache)
echo "Installing Composer dependencies..."
composer install --no-interaction --optimize-autoloader

# Ensures correct permissions
echo "===================== PROXIES SETUP ====================="
mkdir -p /var/www/html/proxies

echo "🔑 Setting owner to www-data:www-data..."
chown -R www-data:www-data /var/www/html/proxies

echo "🛡️ Setting permissions..."
chmod -R 775 /var/www/html/proxies

echo "✅ Proxy directory ready!"

# Run migrations when starting the project
echo "===================== MIGRATIONS ====================="
composer migrate
echo "Migrations executed successfully!"

# Populate the bank with seeders
echo "===================== SEED DATA ====================="
composer seed
echo "Data loaded successfully!"

# Running unit tests
echo "===================== RUNNING TESTS ====================="
composer test
echo "Tests executed successfully!"

exec apache2-foreground

