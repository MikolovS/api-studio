#!/bin/bash


SCRIPT_PATH="`dirname \"$0\"`"              # relative
SCRIPT_PATH="`( cd \"$SCRIPT_PATH\" && pwd )`"  # absolutized and normalized

cd "$SCRIPT_PATH/docker" && \
	docker-compose up -d

sleep 2

CONTAINER_API=$(docker ps -aqf "name=app.test")

docker exec $CONTAINER_API mkdir -p storage/framework/sessions
docker exec $CONTAINER_API mkdir -p storage/framework/views
docker exec $CONTAINER_API mkdir -p storage/framework/cache
docker exec $CONTAINER_API chmod 777 -R storage/

docker exec $CONTAINER_API php artisan config:clear
docker exec $CONTAINER_API php artisan key:generate