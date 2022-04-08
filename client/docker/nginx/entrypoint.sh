#!/bin/sh
set -e

uid=$(stat -c %u /srv/app)

echo "ENTRYPOINT HTTP => $uid"

umask 007;
if [ ! -d "/srv/app/var/log" ]; then
  mkdir -m 777 -p /srv/app/var/log;
fi
if [ ! -f "/srv/app/var/log/www.access.log" ]; then
    echo "" > /srv/app/var/log/www.access.log;
    echo "www.access.log created "
fi

if [ ! -f "/srv/app/var/log/php.error.log" ]; then
    echo "" > /srv/app/var/log/php.error.log;
    echo "php.error.log created "
fi

chown $uid /srv/app/var/log/www.access.log;
chown $uid /srv/app/var/log/php.error.log;

chmod 777 /srv/app/var/log/www.access.log;
chmod 777 /srv/app/var/log/php.error.log;

nginx -g 'daemon off;'