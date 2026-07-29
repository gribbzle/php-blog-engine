FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    oniguruma-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring intl opcache \
    && rm -rf /tmp/* /var/cache/apk/*

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
