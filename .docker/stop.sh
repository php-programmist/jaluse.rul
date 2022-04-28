#!/bin/bash

log_message()
{
    LOGPREFIX="[$(date '+%Y-%m-%d %H:%M:%S')]"
    MESSAGE=$1
    echo "$LOGPREFIX $MESSAGE"
}


log_message "Stopping containers..."
docker-compose stop

log_message "Removing containers..."
docker-compose rm -f