FROM php:8.2-fpm-alpine

ARG UID
ARG GID

RUN apk --update --no-cache add \
  git \
  bash \
  curl \
  icu-dev \
  libpng-dev \
  libjpeg-turbo-dev \
  freetype-dev \
  libzip-dev \
  libwebp-dev

# Get Composer
RUN apk --no-cache add curl && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup -g $GID webgroup
RUN adduser -D -u $UID -G webgroup user

# Set access rights to the directories where Composer will be installed
RUN chown -R user:webgroup /usr/local/bin

# Install xdebug
RUN apk add --update linux-headers \
    && apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-3.3.0 \
    && docker-php-ext-enable xdebug

COPY docker/php/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

USER user

WORKDIR /var/www/html

EXPOSE 9000