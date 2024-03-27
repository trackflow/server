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
    && composer install --prefer-dist --no-progress --no-dev

EXPOSE 8815
EXPOSE 8816
EXPOSE 5555
EXPOSE 4343
EXPOSE 1025

LABEL org.opencontainers.image.source=https://github.com/trackflow/server
LABEL org.opencontainers.image.description="Trackflow server"
LABEL org.opencontainers.image.licenses=MIT

ENTRYPOINT ["./docker/entrypoint.sh"]