# Utiliser l'image officielle de PHP avec Apache, version 8.0
FROM php:8.2-apache

# Installer les dépendances système pour Laravel et les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Activer le mod_rewrite d'Apache pour les routes Laravel
RUN a2enmod rewrite

# Définir le répertoire de travail dans le conteneur
WORKDIR /var/www/html

# Copier le contenu de l'application Laravel dans le répertoire de travail
COPY . .

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer les dépendances de l'application via Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Changer la propriété du répertoire /var/www/html au www-data d'Apache
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80
EXPOSE 80
