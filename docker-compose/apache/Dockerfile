FROM ubuntu/apache2
RUN apt update;
# Copy apache vhost file to proxy php requests to php-fpm container
COPY demo.apache.conf /etc/apache2/sites-available/demo.apache.conf
COPY apache.conf /etc/apache2/apache.conf
RUN a2dissite 000-default.conf;
RUN a2ensite demo.apache.conf;
RUN a2enmod rewrite && /etc/init.d/apache2 restart
