FROM php:8-apache-bullseye
RUN apt-get update; \
    apt-get install -y libmagickwand-dev; \
    pecl install imagick; \
    docker-php-ext-enable imagick; \
    apt-get clean autoclean; \
    apt-get autoremove --yes; \
    rm -rf /var/lib/apt/lists/*;
    
COPY html/ /var/www/html/

