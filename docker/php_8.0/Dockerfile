# Исходный образ для основы
FROM php:8.0-fpm-alpine

# Выполняет команду в контексте образа.
RUN echo "UTC" && apk --update add tzdata && \
    cp /usr/share/zoneinfo/UTC /etc/localtime && \
    echo UTC > /etc/timezone && \
    apk del tzdata

RUN apk add --update --no-cache icu-libs libintl build-base zlib-dev cyrus-sasl-dev libgsasl-dev oniguruma-dev procps imagemagick patch bash htop acl apk-cron \
        augeas-dev autoconf curl ca-certificates dialog freetype-dev gomplate git gcc gettext-dev icu-dev libcurl libffi-dev libgcrypt-dev libjpeg-turbo-dev \
        libpng-dev libmcrypt-dev libressl-dev libxslt-dev libzip-dev linux-headers libxml2-dev ldb-dev make musl-dev \
        mysql-client openssh-client pcre-dev ssmtp su-exec wget nodejs npm

# Исправляет работу библиотеки iconv с alpine
RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN php -m && \
    docker-php-ext-configure bcmath --enable-bcmath && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-configure gettext && \
    docker-php-ext-configure intl --enable-intl && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-configure pcntl --enable-pcntl && \
    docker-php-ext-configure zip --with-zip && \
    docker-php-ext-install exif sockets mysqli opcache xsl bcmath gd gettext intl opcache pcntl zip calendar pdo_mysql && \
    docker-php-ext-enable exif sockets mysqli opcache xsl bcmath gd gettext intl opcache pcntl zip calendar pdo_mysql

RUN npm install -g sass
RUN rm -rf /var/cache/apk/* && docker-php-source delete
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer

RUN wget phar.phpunit.de/phpunit-6.0.phar && \
        chmod +x phpunit-6.0.phar && \
        mv phpunit-6.0.phar /usr/local/bin/phpunit

ADD . /application/filp.loc
RUN chown -R www-data:www-data /application/filp.loc

WORKDIR "/application/filp.loc"
