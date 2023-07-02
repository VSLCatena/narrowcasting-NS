FROM php:8.2-fpm-alpine
RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
        chmod +x /usr/local/bin/install-php-extensions && \
        install-php-extensions imagick && \
        docker-php-ext-enable imagick && \
        rm -rf /var/cache/apk/*
