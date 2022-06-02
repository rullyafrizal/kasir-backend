#!/bin/sh

# $PORT is the port that the container listens on
# The value is passed in via the environment variable (.env file)
sed -i "s,LISTEN_PORT,$PORT,g" /etc/nginx/nginx.conf

php-fpm -D

# while ! nc -w 1 -z 127.0.0.1 9000; do sleep 0.1; done;

nginx