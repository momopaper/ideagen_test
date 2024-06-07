#!/bin/bash

# Read secrets
DB_DATABASE=$(cat /run/secrets/db_database)
DB_PASSWORD=$(cat /run/secrets/db_password)

# Update .env file
sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_DATABASE}/" /var/www/ideagen/.env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/" /var/www/ideagen/.env

# Migrate, seed and generate key
php artisan migrate
php artisan db:seed
php artisan key:generate

# Execute the CMD from the Dockerfile
exec "$@"
