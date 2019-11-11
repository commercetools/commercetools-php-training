FROM php:7.3-fpm-alpine

EXPOSE 8000

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV COMPOSER_VERSION 1.9.1
ENV COMPOSER_INSTALLER_SIG a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === '${COMPOSER_INSTALLER_SIG}') { echo 'Installer verified' . PHP_EOL; exit(0); } else { echo 'Installer corrupt' . PHP_EOL; unlink('composer-setup.php'); exit(1); }" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION} \
    && php -r "unlink('composer-setup.php');" \
    && composer --ansi --version --no-interaction

ENV PHPIZE_DEPS \
        autoconf \
        dpkg-dev dpkg \
        file \
        g++ \
        gcc \
        libc-dev \
        make \
        pkgconf \
        re2c

ADD config/60-user.ini /usr/local/etc/php/conf.d/

RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
    && apk add --no-cache icu-dev \
    && pecl install apcu \
    && pecl install xdebug \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl \
    && docker-php-ext-enable apcu \
    && docker-php-ext-enable xdebug \
    && apk del --no-network .build-deps \
    && php -i \
    && php -m

