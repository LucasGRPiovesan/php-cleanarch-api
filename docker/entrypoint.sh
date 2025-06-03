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

# Run migrations when starting the project
echo "===================== MIGRATIONS ====================="
composer migrate
echo "Migrations executed successfully!"

# Populate the bank with seeders
echo "===================== SEED DATA ====================="
composer seed
echo "Data loaded successfully!"

exec apache2-foreground

