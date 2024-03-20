FROM php:8.3-cli-alpine3.18

WORKDIR /app

COPY . .

RUN apk add --no-cache \
        curl \
        libcurl \
    && docker-php-ext-install \
        opcache \
    && docker-php-source delete \
    && apk del ${BUILD_DEPENDS} \
    && rm -rf /var/cache/apk/* \
    && curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer \
    && composer install --no-dev \
    && mkdir var \
    && chmod -R 777 var

EXPOSE 8080
EXPOSE 8888
EXPOSE 5555
EXPOSE 4343
EXPOSE 1025

ENTRYPOINT ["./docker/entrypoint.sh"]