FROM php:5.6-apache
# WORKDIR /var/www/

RUN apt-get update && \
    apt-get install -y libssl-dev && \
    apt-get install -y ffmpeg && \
    pecl install mongo && \
    docker-php-ext-enable mongo

# COPY . finki_forum
RUN chown -R www-data:www-data /var/www

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite && service apache2 restart