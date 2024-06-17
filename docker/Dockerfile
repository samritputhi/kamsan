FROM php:8.2.0alpha1-fpm-alpine

RUN apk add --no-cache nginx wget

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app

COPY . /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"

RUN docker-php-ext-install pdo_mysql pdo

RUN cd /app && \
    /usr/local/bin/composer install --ignore-platform-reqs
RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh
FROM php:8.0-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/
COPY .env.example .env /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mariadb-client \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl opcache
#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
# RUN docker-php-ext-install gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd


# Install Postgre PDO
#RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_21.x | bash
RUN apt-get install -y nodejs
# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www
#


#RUN php artisan migrate --seed and run dev
#CMD ["/bin/sh", "-c", "composer install"]
#CMD ["/bin/sh", "-c", "php artisan migrate --seed"]
#CMD ["/bin/sh", "-c", "php artisan key:generate"]
#CMD ["/bin/sh", "-c", "php artisan config:cache"]
#CMD ["/bin/sh", "-c", "php artisan cache:clear"]
#CMD ["/bin/sh", "-c", "php artisan optimize:clear"]
#
#USER root
#CMD ["/bin/sh", "-c", "npm install"]
#CMD ["/bin/sh", "-c", "npm run dev"]


# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

