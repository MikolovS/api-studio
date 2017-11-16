#!/bin/bash


SCRIPT_PATH="`dirname \"$0\"`"              # relative
SCRIPT_PATH="`( cd \"$SCRIPT_PATH\" && pwd )`"  # absolutized and normalized

if [ -z "$SCRIPT_PATH" ] ; then
  # error; for some reason, the path is not accessible
  # to the script (e.g. permissions re-evaled after suid)
  exit 1  # fail
fi

printf "PROJECT_DIR=$SCRIPT_PATH/.." > "$SCRIPT_PATH/docker/.env"

if [ -f "$SCRIPT_PATH/.env" ]; then # если есть уже .env файл
        rm "$SCRIPT_PATH/.env"  # удаляем его
    fi

cp "$SCRIPT_PATH/docker/dev.env" "$SCRIPT_PATH/../.env"

cd "$SCRIPT_PATH/docker" && \
	docker-compose build


docker run --rm --interactive --tty \
    --volume "$SCRIPT_PATH/..":/var/www/ \
    -w /var/www/ \
    composer install