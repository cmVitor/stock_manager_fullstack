#!/usr/bin/env bash

# Fail on first error
set -e

echo "Aguardando Postgres iniciar..."

# Aguarda o banco responder
until php -r "try { new PDO('pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}'); echo 'Postgres disponível.'; } catch (Exception \$e) { exit(1); }";
do
    sleep 2
done

echo "Postgres conectado!"

echo "Executando migrations..."
php artisan migrate --force

echo "Executando seeders..."
php artisan db:seed --force

echo "Migrations concluídas!"

echo "Iniciando servidor Laravel..."
php artisan serve --host=0.0.0.0 --port=8000
