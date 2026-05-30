FROM phalconphp/cphalcon:v5.9.3-php8.2

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

ENV HTTP_HOST=0.0.0.0
ENV HTTP_PORT=8080

EXPOSE 8080

CMD ["sh", "-c", "php -S ${HTTP_HOST}:${HTTP_PORT} -t public"]
