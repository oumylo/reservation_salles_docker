#!/bin/bash

set -e

echo "Démarrage de PHP-FPM..."
php-fpm -D

echo "Démarrage de Nginx..."

# Railway utilise la variable PORT.
# Si PORT n'existe pas, on utilise 8080.
PORT=${PORT:-8080}

# Nginx doit écouter sur le port fourni par Railway.
sed -i "s/listen 8080;/listen ${PORT};/" /etc/nginx/conf.d/default.conf

nginx -g "daemon off;"
