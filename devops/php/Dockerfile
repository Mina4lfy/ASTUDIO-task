# Arguments defined in docker-compose.yml
ARG PHP_VERSION="8.2"
ARG user='laravel'
ARG uid=1000

FROM php:${PHP_VERSION}-fpm-alpine

# Install system dependencies
RUN apk update \
  && apk --no-cache add \
    mysql-client \
    tar \
    libpq-dev \
    libical-dev \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
  && docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd calendar zip
# opcache

# Clear cache
RUN rm -rf /var/cache/apk/*

# PostgresSQL
# RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd
# RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# Get latest composer & install its packages (no need to install composer packages in the image for now)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# RUN composer install --no-dev

# Set working directory
WORKDIR /var/www/html

# Create user  and set up home directory
RUN adduser -D -u 1000 -G www-data laravel \
  && mkdir -p /home/laravel/.composer \
  && chown -R laravel:www-data /home/laravel

# Copy source code
COPY . .

# Install npm dependencies
# RUN curl -o nodejs.tar.xz https://nodejs.org/dist/latest-v13.x/node-v13.14.0-linux-x64.tar.xz \
#   && tar -xvf nodejs.tar.xz \
#   && mv node-v13.14.0-linux-x64/ /usr/local/node \
#   && echo 'export PATH=/usr/local/node/bin:$PATH' >> ~/.bashrc \
#   && rm nodejs.tar.xz
# ENV PATH="/usr/local/node/bin:${PATH}"
# RUN echo "source ~/.bashrc" >> ~/.bash_profile

USER laravel

# Expose ports: 80, 443, and 9000 (fast-cgi)
EXPOSE 80 443 9000

# Start PHP-FPM
CMD ["php-fpm", "-F"]