#!/bin/sh

INTERNAL_USER_ID=$(id -u www-data)
INTERNAL_GROUP_ID=$(id -g www-data)

echo "Setting the correct user and group id for shell use"
if [ ${USER_ID} != ${INTERNAL_USER_ID} ]; then
  usermod -u ${USER_ID} www-data
fi

if [ ${GROUP_ID} != ${INTERNAL_GROUP_ID} ]; then
  groupmod -g ${GROUP_ID} www-data
fi

if [ ${GROUP_ID} ] && [ ${USER_ID} ]; then
  chown www-data:www-data /var/www
fi

echo "Launch application"
exec "$@"