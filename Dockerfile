FROM php:8.3-fpm

# Installation de Nginx et des dépendances nécessaires
RUN apt-get update \
    && apt-get install -y nginx unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copie du projet
COPY . .

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Configuration Nginx
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Le script démarre PHP-FPM puis Nginx
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Railway fournit le port via la variable PORT.
# Nginx écoutera sur 8080 dans le conteneur.
EXPOSE 8080

CMD ["/usr/local/bin/start.sh"]