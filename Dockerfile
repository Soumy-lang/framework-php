# Utilise l'image PHP 8.2 avec Apache
FROM php:8.2-apache

# Met à jour les paquets disponibles
RUN apt-get update

# Installe les extensions PDO et MySQLi
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Installe les extensions GD pour la manipulation d'images
RUN apt-get install -y libpng-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype \
    && docker-php-ext-install gd

# Installe Node.js et npm
RUN apt-get install -y npm

# Installe SASS globalement
RUN npm install -g sass

# Installe et active l'extension YAML
RUN apt-get install -y libyaml-dev \
    && pecl install yaml \
    && docker-php-ext-enable yaml

# Modifie l'utilisateur pour éviter des problèmes de permissions
RUN usermod -u 1000 www-data

# Active le module rewrite d'Apache
RUN a2enmod rewrite
