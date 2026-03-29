FROM php:8.2-apache

# Installer extensions PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Activer Apache rewrite (optionnel)
RUN a2enmod rewrite