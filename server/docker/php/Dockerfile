FROM php:7.4-fpm-buster

#######################
# Changement d'heure  #
#######################
ENV TIMEZONE Europe/Paris

RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime
RUN echo "${TIMEZONE}" > /etc/timezone

# Add backport
COPY etc/apt/sources.list /etc/apt/sources.list

RUN apt-get update && \
    # Infra tools
    apt-get install -y git vim gosu cron curl wget zip unzip make acl file gettext jq && \
    # Locales
    apt-get install -y locales locales-all && \
    # PHP Extensions
    apt-get install -y libldap2-dev libxml++2.6-dev libicu-dev libpng-dev libbz2-dev libjpeg-dev libzip-dev zlib1g-dev && \
    # ImageMagick & OpenSSL
    apt-get install -y libmagickwand-dev openssl libssl-dev && \
    # PhantomJS
    apt-get install -y libfreetype6-dev libfontconfig1-dev && \
    # Clean
    rm -rf /var/lib/apt/lists/* && \
    apt-get clean

RUN apt-get update && \
    apt-get install -y graphviz && \
    rm -rf /var/lib/apt/lists/* && \
    apt-get clean

#######################
# Fix MinProtocol TLS #
#######################
RUN sed -i 's/MinProtocol.*$/Minprotocol = TLSv1/' /etc/ssl/openssl.cnf && \
    sed -i 's/CipherString.*$/CipherString = DEFAULT@SECLEVEL=1/' /etc/ssl/openssl.cnf

#######################
# Ajout des extension #
#        PHP          #
#######################
RUN pecl install -o -f redis-5.0.2 apcu xdebug imagick && \
    rm -rf /tmp/pear

RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-configure intl && \
    docker-php-ext-configure zip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install mysqli pdo_mysql bcmath ldap intl zip soap gd bz2 opcache && \
    docker-php-ext-enable redis apcu imagick && \
    docker-php-ext-install xmlrpc && \
    docker-php-ext-enable xmlrpc && \
    docker-php-source delete

#######################
# Install Composer    #
#######################
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

#######################
# Install Symfony     #
#######################
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

#######################
# Ajout de la conf    #
#        PHP          #
#######################
COPY usr/local/etc/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY usr/local/etc/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY usr/local/etc/php/php.ini /usr/local/etc/php/php.ini
COPY usr/local/etc/php/conf.d/php-optimized-for-symfony.ini /usr/local/etc/php/conf.d/php-optimized-for-symfony.ini

#######################
# Ajout de la conf    #
#   d'environnement   #
#######################
COPY etc/bash.bashrc /etc/bash.bashrc

#######################
# Ajout de la conf    #
#   d'entrypoint      #
#######################
COPY entrypoint-fpm.sh /usr/local/bin/entrypoint.sh

#######################
# Auto-certificate    #
#######################
COPY usr/local/share/ca-certificates/ca.crt /usr/local/share/ca-certificates/ca.crt
COPY usr/local/share/ca-certificates/ad-ca.crt /usr/local/share/ca-certificates/ad-ca.crt
RUN cd /usr/local/share/ca-certificates && \
    update-ca-certificates

#######################
#   Fix ldap cert     #
#     self-signed     #
#######################
RUN echo "TLS_REQCERT     never" >> /etc/ldap/ldap.conf

#####################################
# BlackFire PHP Probe installation  #
#####################################
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && architecture=$(uname -m) \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/$architecture/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8307\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

EXPOSE 9001
