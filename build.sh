#!/usr/bin/env bash

echo "🚀 Instalando dependencias..."
composer install --no-dev --optimize-autoloader

echo "🏗️ Construyendo frontend..."
npm ci
npm run build

echo "🔑 Configurando aplicación..."
php artisan key:generate --force
php artisan migrate --force
php artisan config:cache

echo "✅ ¡Listo!"