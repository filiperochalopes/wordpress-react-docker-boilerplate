
FROM php:7.3.28-apache

ARG WORDPRESS_UPSTREAM_VERSION
ARG WORDPRESS_VERSION
ARG WORDPRESS_URL=https://br.wordpress.org/wordpress-${WORDPRESS_VERSION}-pt_BR.tar.gz
ARG WORDPRESS_SHA1;

RUN a2enmod rewrite

# install the PHP extensions we need
RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev && \
    rm -rf /var/lib/apt/lists/* \
	    && docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
	    && docker-php-ext-install gd
RUN docker-php-ext-install mysqli

VOLUME /var/www/html

# upstream tarballs include ./wordpress/ so this gives us /usr/src/wordpress
RUN curl -o wordpress.tar.gz -SL ${WORDPRESS_URL} \
	&& echo "$(curl -fLs https://br.wordpress.org/wordpress-${WORDPRESS_VERSION}-pt_BR.tar.gz.sha1 | tee $WORDPRESS_SHA1) *wordpress.tar.gz" | sha1sum -c - \
	&& tar -xzf wordpress.tar.gz -C /usr/src/ \
	&& rm wordpress.tar.gz \
	&& chown -R www-data:www-data /usr/src/wordpress

COPY docker-entrypoint.sh /entrypoint.sh

EXPOSE 80
# grr, ENTRYPOINT resets CMD now
ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]