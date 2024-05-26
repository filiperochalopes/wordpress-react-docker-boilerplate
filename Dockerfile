
FROM wordpress:6.5.3-apache

RUN ls -la /var/www/html

WORKDIR /var/www

RUN cp -r html wp
RUN rm -rf html/*
RUN mv wp html/wp

WORKDIR /var/www/html/wp

RUN chmod 777 .htaccess

# Setup SMTP by running apache2-config.sh
COPY ["apache2-config.sh", "/usr/local/bin/"]
RUN chmod +x /usr/local/bin/apache2-config.sh

CMD ["apache2-config.sh"]