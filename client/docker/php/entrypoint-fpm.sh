#!/bin/sh
set -e

uid=$(stat -c %u /srv/app)
gid=$(stat -c %g /srv/app)
user_name="www-data"
group_name="www-data"

# Fix permissions
chown :www-data -R /srv
chmod g=u -R /srv
chmod g+s -R /srv
chmod 755 /srv

if [ $uid = 0 ] && [ $gid = 0 ]; then
	if [ $# -eq 0 ]; then
	    php-fpm
	else
	    exec "$@"
	fi
fi


sed -i -r "s/$user_name:x:[[:digit:]]+:[[:digit:]]+:/$user_name:x:$uid:$gid:/g" /etc/passwd
sed -i -r "s/$group_name:x:[[:digit:]]+:/$group_name:x:$gid:/g" /etc/group

user=$(grep ":x:$uid:" /etc/passwd | cut -d: -f1)
chown -Rf $uid:$gid /home
chown -Rf $uid:$gid /var/www || true

if [ $# -eq 0 ]; then
    php-fpm
else
    exec gosu $user "$@"
fi
